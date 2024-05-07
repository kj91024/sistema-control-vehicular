<?php
namespace App\Services;

use App\Entities\Car;
use App\Entities\Record;
use App\Models\Cars;
use App\Models\Records;

class RecordService{
    protected Records $recordModel;
    protected CarService $carService;
    public function __construct()
    {
        $this->recordModel = model("Records");
        $this->carService = new CarService();
    }
    private function timeElapsedString($datetime, $full = false, $now = new \DateTime) {
        //$now = new \DateTime;
        $ago = new \DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'año',
            'm' => 'mes',
            'w' => 'semana',
            'd' => 'dia',
            'h' => 'hora',
            'i' => 'minuto',
            's' => 'segundo',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? 'Hace '. implode(', ', $string) : 'Justo ahora';
    }
    private function cleanList($list): array
    {
        $list = array_map(function($data){
            $date = $data->updated_at->toDateTimeString();
            $init = strtotime($date);
            $finish = strtotime($date.' +2 minutes');
            if ( (time() >= $init) && (time() <= $finish) )
                return $data;
            return;
        }, $list);
        $list = array_filter($list);
        return $list;
    }
    private function filterList($list): array
    {
        $list = array_map(function($data){
            $date = $data->updated_at->toDateTimeString();
            $init = strtotime($date);
            $finish = strtotime($date.' +24 hours');
            $data->toomuch = !((time() >= $init) && (time() <= $finish));
            $data->toago = $this->timeElapsedString($date);

            $date = strtotime($date.' +2 minutes');
            if ( time() >= $date )
                return $data;
            return;
        }, $list);
        $list = array_filter($list);
        return $list;
    }
    public function getCarsEntering(): array
    {
        $car_entering = $this->recordModel
            ->select([
                'cars.id', 'cars.plate', 'cars.color',
                'users.dni', 'users.first_names', 'users.last_names', 'users.cellphone',
                'records.created_at', 'records.updated_at'
            ])
            ->join('cars', 'cars.id = records.id_car')
            ->join('users', 'users.id = cars.id_user')
            ->where('records.type', 'in')
            ->orderBy('records.updated_at','DESC')
            ->findAll();
        return $this->cleanList($car_entering);
    }
    public function getCarsInParking(): array
    {
        $in_parking = $this->recordModel
            ->select([
                'cars.id', 'cars.plate', 'cars.color',
                'users.id as id_user', 'users.dni', 'users.first_names', 'users.last_names', 'users.cellphone',
                'records.created_at', 'records.updated_at'
            ])
            ->join('cars', 'cars.id = records.id_car')
            ->join('users', 'users.id = cars.id_user')
            ->where('records.type', 'in')
            ->orderBy('records.updated_at','DESC')
            ->findAll();
        return $this->filterList($in_parking);
    }
    public function getCarsLeaving(): array
    {
        $car_leaving = $this->recordModel
            ->select([
                'cars.id', 'cars.plate', 'cars.color',
                'users.dni', 'users.first_names', 'users.last_names', 'users.cellphone',
                'records.created_at', 'records.updated_at'
            ])
            ->join('cars', 'cars.id = records.id_car')
            ->join('users', 'users.id = cars.id_user')
            ->where('records.type', 'out')
            ->orderBy('records.updated_at','DESC')
            ->findAll();
        return $this->cleanList($car_leaving);
    }
    public function getHistory(int $id_car): array
    {
        $records = $this->recordModel
                    ->where('id_car', $id_car)
                    ->orderBy('id', 'DESC')
                    ->findAll();

        $history = [];
        $i = 0;
        if(count($records) > 0) {
            for ($i = 0; $i - 1 < count($records); $i += 2) {
                $ra = $records[$i]->created_at->toDateTimeString();
                $rc = [];
                if (isset($records[$i + 1])) {
                    $rc = $records[$i + 1]->created_at->toDateTimeString();
                    $rb = $this->timeElapsedString($rc, false, new \DateTime($ra));
                    $rb = 'Estuvo en el estacionamiento ' . str_replace('Hace ', '', $rb);
                } else {
                    $rc = '';
                    $rb = $this->timeElapsedString(date('Y-m-d H:i:s'), false, new \DateTime($ra));
                    $rb = 'Está en el estacionamiento ' . strtolower($rb);
                }
                $history[] = compact('ra', 'rb', 'rc');
            }
        }

        return $history;
    }
    private function getPlatesNoRegisteredWithRQ(): array
    {
        $con_rq = $this->recordModel->select([
            'records.*',
            'cars.plate',
            'COUNT(records.id_car) as count',
            'MAX(records.updated_at) as updated_at'
        ])
            ->join('cars', 'records.id_car = cars.id')
            ->join('sat', 'sat.plate = cars.plate')
            ->where('id_user', NULL)
            ->where('type', 'no-registered')
            ->groupBy('records.id_car')
            ->findAll();

        return array_map(function($item){
            $item->rq = true;
            return $item;
        }, $con_rq);
    }
    private function getPlatesNoRegisteredWithoutRQ(array $ids): array
    {
        $sin_rq = $this->recordModel->select([
            'records.*',
            'cars.plate',
            'COUNT(records.id_car) as count',
            'MAX(records.updated_at) as updated_at'
        ])->join('cars', 'records.id_car = cars.id');
        if(!empty($ids)){
            $sin_rq = $sin_rq->whereNotIn('records.id_car', $ids);
        }
        $sin_rq = $sin_rq->where('id_user', NULL)
            ->where('type', 'no-registered')
            ->groupBy('records.id_car')
            ->findAll();

        return array_map(function($item){
            $item->rq = false;
            return $item;
        }, $sin_rq);
    }
    public function getPlatesNoRegistered(): array
    {
        // Obtenemos autos con RQ
        $con_rq = $this->getPlatesNoRegisteredWithRQ();
        $ids = array_column($con_rq, 'id_car');

        // Autos sin RQ
        $sin_rq = $this->getPlatesNoRegisteredWithoutRQ($ids);

        return array_merge($sin_rq, $con_rq);
    }

    public function registerCarEntry(string $plate): string
    {
        $id_car = $this->carService->saveDefaultCar($plate);
        $car = $this->carService->getCarWithUser($plate);

        if(is_null($car)){
            $this->insert($id_car, 'no-registered');
            return json_encode([
                'status' => 'error',
                'message' => 'Carro está en el ingreso pero no está registrado en la base de datos, no puede ingresar.'
            ]);
        } else {
            // Si existe la placa se guarda como ingresando
            $this->save($car->id, 'in');
            return json_encode([
                'status' => 'success',
                'message' => 'Carro está en el ingreso, puede ingresar'
            ]);
        }
    }
    public function registerCarExit(string $plate){
        $this->carService->saveDefaultCar($plate);
        $car = $this->carService->getCarWithUser($plate);
        if(is_null($car)){
            return json_encode([
                'status' => 'error',
                'message' => 'Carro está en la salida pero no está registrado en la base de datos, no puede salir.'
            ]);
        } else {
            // Si existe la placa se guarda como saliendo
            $this->save($car->id, 'out');
            return json_encode([
                'status' => 'success',
                'message' => 'Carro está en la salida, puede salir'
            ]);
        }
    }
    private function insert(int $id_car, string $type){
        $record = new Record();
        $record->id_car = $id_car;
        $record->type = $type;
        $this->recordModel->insert($record);
    }
    private function save(int $id_car, string $type){
        $record = $this->recordModel
                        ->where('id_car', $id_car)
                        ->first();
        if(is_null($record)) {
            $record = new Record();
        }
        $record->id_car = $id_car;
        $record->type = $type;
        if($record->hasChanged()) {
            $this->recordModel->save($record);
        }
    }
}