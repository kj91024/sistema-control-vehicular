<?php
namespace App\Services;

use App\Entities\Car;
use App\Entities\Record;
use App\Models\Cars;
use App\Models\Records;

class RecordService{
    protected Records $recordModel;
    protected CarService $carService;
    protected SatService $satService;
    protected PlaceService $placeService;
    public function __construct()
    {
        $this->recordModel = model("Records");
        $this->carService = new CarService();
        $this->satService = new SatService();
        $this->placeService = new PlaceService();
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
            $date = $data->created_at->toDateTimeString();
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
            $date = $data->created_at->toDateTimeString();
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
                'records.created_at', 'records.updated_at', 'records.floor', 'records.letter', 'records.number',
                'places.place_name', 'places.place_address'
            ])
            ->join('cars', 'cars.id = records.id_car')
            ->join('users', 'users.id = cars.id_user')
            ->join('places', 'places.id = records.id_place')
            ->where('records.type', 'in')
            ->orderBy('records.created_at','DESC')
            ->findAll();
        return $this->cleanList($car_entering);
    }
    public function getCarsInParking(): array
    {
        $in_parking = $this->recordModel
            ->select([
                'cars.id', 'cars.plate', 'cars.color',
                'users.id as id_user', 'users.dni', 'users.first_names', 'users.last_names', 'users.cellphone', 'users.license_number',
                'records.created_at', 'records.updated_at', 'records.floor', 'records.letter', 'records.number',
                'places.place_name', 'places.place_address'
            ])
            ->join('cars', 'cars.id = records.id_car')
            ->join('users', 'users.id = cars.id_user')
            ->join('places', 'places.id = records.id_place')
            ->where('records.type', 'in')
            ->orderBy('records.created_at','DESC')
            ->findAll();
        return $this->filterList($in_parking);
    }
    public function getCarsLeaving(): array
    {
        $car_leaving = $this->recordModel
            ->select([
                'cars.id', 'cars.plate', 'cars.color',
                'users.dni', 'users.first_names', 'users.last_names', 'users.cellphone',
                'records.created_at', 'records.updated_at', 'records.floor', 'records.letter', 'records.number',
                'places.place_name', 'places.place_address'
            ])
            ->join('cars', 'cars.id = records.id_car')
            ->join('users', 'users.id = cars.id_user')
            ->join('places', 'places.id = records.id_place')
            ->where('records.type', 'out')
            ->orderBy('records.created_at','DESC')
            ->findAll();
        return $this->cleanList($car_leaving);
    }
    public function getHistory(int $id_car): array
    {
        $records = $this->recordModel
                    ->select([
                        'records.*',
                        'places.place_name', 'places.place_address', 'places.id as id_place'
                    ])
                    ->join('places', 'places.id = records.id_place')
                    ->where('id_car', $id_car)
                    ->orderBy('id', 'DESC')
                    ->findAll();
        $history = [];
        if(count($records) > 0) {
            for ($i = 0; $i + 1 <= count($records); $i += 2) {
                $record = $records[$i];
                $ra = $record->created_at->toDateTimeString();
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

                $place_name = $record->place_name;
                $place_address = $record->place_address;
                $id_record = $record->id;
                $id_place = $record->id_place;
                $floor = $record->floor;
                $letter = $record->letter;
                $number = $record->number;
                $history[] = compact('ra', 'rb', 'rc', 'id_record', 'id_place', 'place_name', 'place_address', 'floor', 'letter', 'number');
            }
        }
        return $history;
    }
    public function getLastHistory(int $id_car): array{
        $list = $this->getHistory($id_car);
        if(empty($list)){
            return [];
        }
        return end($list);
    }
    private function getPlatesNoRegisteredWithRQ(): array
    {
        $con_rq = $this->recordModel->select([
            'records.*',
            'cars.plate',
            'places.place_name', 'places.place_address',
            'COUNT(records.id_car) as count',
            'MAX(records.updated_at) as updated_at'
        ])
            ->join('cars', 'records.id_car = cars.id')
            ->join('sat', 'sat.plate = cars.plate')
            ->join('places', 'places.id = records.id_place')
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
            'places.place_name', 'places.place_address',
            'COUNT(records.id_car) as count',
            'MAX(records.updated_at) as updated_at'
        ])
            ->join('cars', 'records.id_car = cars.id')
            ->join('places', 'places.id = records.id_place');
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

    public function registerCarEntry(int $id_place, string $plate): string
    {
        $id_car = $this->carService->saveDefaultCar($plate);
        $car = $this->carService->getCarWithUser($plate);

        if(is_null($car)){
            $this->insert($id_car, $id_place, 'no-registered');
            if($this->satService->existPlate($plate)){
                return json_encode([
                    'status' => 'danger',
                    'message' => 'Cuidado el carro está con RQ, ya se le ha avisado a la policía'
                ]);
            }

            return json_encode([
                'status' => 'error',
                'message' => 'Un carro está en el ingreso pero no está registrado en la base de datos, no puede ingresar.'
            ]);
        }

        // Si existe la placa se guarda como ingresando
        $this->save($car->id, $id_place, 'in');
        return json_encode([
            'status' => 'success',
            'message' => 'Un carro está en el ingreso, puede ingresar'
        ]);
    }
    public function registerCarExit(int $id_place, string $plate){
        $this->carService->saveDefaultCar($plate);
        $car = $this->carService->getCarWithUser($plate);
        if(is_null($car)){
            return json_encode([
                'status' => 'error',
                'message' => 'Un carro está en la salida pero no está registrado en la base, no puede salir.'
            ]);
        }

        $hasPlaceDefined = $this->placeService->hasPlaceDefined($car->id);
        if(!$hasPlaceDefined){
            return json_encode([
                'status' => 'error',
                'message' => 'Un carro está en la salida pero no ha configurado la ubicación en la que estaba parqueado, no puede salir.'
            ]);
        }

        // Si existe la placa se guarda como saliendo
        $this->save($car->id, $id_place, 'out');
        return json_encode([
            'status' => 'success',
            'message' => 'Un carro está en la salida, puede salir'
        ]);
    }
    private function insert(int $id_car, int $id_place, string $type){
        $record = new Record();
        $record->id_car = $id_car;
        $record->id_place = $id_place;
        $record->type = $type;
        $this->recordModel->insert($record);
    }
    private function save(int $id_car, int $id_place, string $type){
        $record = $this->recordModel
                        ->where('id_car', $id_car)
                        ->first();
        if(is_null($record)) {
            $record = new Record();
        }
        $record->id_car = $id_car;
        $record->id_place = $id_place;
        $record->type = $type;
        if($record->hasChanged()) {
            $this->recordModel->save($record);
        }
    }
    public function getRecordById(int $id_record){
        return $this->recordModel->find($id_record);
    }
    public function updatePlace(int $id_record, string $place){
        $place = explode('|', $place);
        $record = $this->getRecordById($id_record);
        $record->floor  = $place[0];
        $record->letter = $place[1];
        $record->number = $place[2];
        if($record->hasChanged()){
            $this->recordModel->save($record);
            return true;
        }
        return false;
    }
}