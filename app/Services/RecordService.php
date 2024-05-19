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
            $date = $data->created_at;
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
            $date = $data->created_at;//->toDateTimeString();
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
        $sql = "SELECT cars.id, cars.plate, cars.color,
                users.dni, users.first_names, users.last_names, users.cellphone, users.license_number, users.id as id_user,
                R.created_at, R.updated_at, R.floor, R.letter, R.number, R.type, R.do,
                places.place_name, places.place_address
                FROM (
                    SELECT *
                    FROM (
                       SELECT *, ROW_NUMBER() OVER (ORDER BY id DESC) AS new_id
                       FROM records
                       WHERE type IN ('in', 'out')
                       ORDER BY id DESC
                    ) AS R
                    GROUP BY R.id_car
                ) AS R
                JOIN cars ON cars.id = R.id_car
                JOIN users ON users.id = cars.id_user
                JOIN places ON places.id = R.id_place
                WHERE R.type = 'in' AND R.do = 1
                GROUP BY R.id_car";
        $car_entering = $this->recordModel->query($sql)->getResult();
        return $this->cleanList($car_entering);
    }
    public function getCarsInParking(): array
    {
        $sql = "SELECT cars.id, cars.plate, cars.color,
                users.dni, users.first_names, users.last_names, users.cellphone, users.license_number, users.id as id_user,
                R.created_at, R.updated_at, R.floor, R.letter, R.number, R.type, R.do,
                places.place_name, places.place_address
                FROM (
                    SELECT *
                    FROM (
                       SELECT *, ROW_NUMBER() OVER (ORDER BY id DESC) AS new_id
                       FROM records
                       WHERE type IN ('in', 'out')
                       ORDER BY id DESC
                    ) AS R
                    GROUP BY R.id_car
                ) AS R
                JOIN cars ON cars.id = R.id_car
                JOIN users ON users.id = cars.id_user
                JOIN places ON places.id = R.id_place
                WHERE R.type = 'in' AND R.do = 1
                GROUP BY R.id_car";
        $in_parking = $this->recordModel->query($sql)->getResult();
        return $this->filterList($in_parking);
    }
    public function getCarsLeaving(): array
    {
        $sql = "SELECT cars.id, cars.plate, cars.color,
                users.dni, users.first_names, users.last_names, users.cellphone, users.license_number, users.id as id_user,
                R.created_at, R.updated_at, R.floor, R.letter, R.number, R.type, R.do,
                places.place_name, places.place_address
                FROM (
                    SELECT *
                    FROM (
                       SELECT *, ROW_NUMBER() OVER (ORDER BY id DESC) AS new_id
                       FROM records
                       WHERE type IN ('in', 'out')
                       ORDER BY id DESC
                    ) AS R
                    GROUP BY R.id_car
                ) AS R
                JOIN cars ON cars.id = R.id_car
                JOIN users ON users.id = cars.id_user
                JOIN places ON places.id = R.id_place
                WHERE R.type = 'out' AND R.do = 1
                GROUP BY R.id_car";
        $car_leaving = $this->recordModel->query($sql)->getResult();
        return $this->cleanList($car_leaving);
    }
    public function getHistoryItem($record){
        $ra = $record->created_at->toDateTimeString();
        // in - do 0
        if($record->do == 0){
            $rb = 'En frente de la baranda de ingreso';
        }
        // in - do 1
        else {
            $rb = $this->timeElapsedString(date('Y-m-d H:i:s'), false, new \DateTime($ra));
            $rb = 'Está en el estacionamiento ' . strtolower($rb);
        }
        $rc = '';

        $place_name = $record->place_name;
        $place_address = $record->place_address;
        $id_record = $record->id;
        $id_place = $record->id_place;
        $floor = $record->floor;
        $letter = $record->letter;
        $number = $record->number;

        return compact('ra', 'rb', 'rc', 'id_record', 'id_place', 'place_name', 'place_address', 'floor', 'letter', 'number');
    }
    public function getHistory(int $id_car): array
    {
        $records = $this->recordModel
            ->select([
                'records.*',
                'places.place_name', 'places.place_address', 'places.id as id_place'
            ])
            ->join('places', 'places.id = records.id_place')
            ->whereIn('type', ['in', 'out'])
            ->where('id_car', $id_car)
            ->orderBy('id', 'DESC')
            ->findAll();

        $history = [];
        if(count($records) > 0) {
            for ($i = 0; $i + 1 <= count($records); $i += 2) {
                $record = $records[$i];
                // solo hay uno
                if (!isset($records[$i + 1])) {
                    $history[] = $this->getHistoryItem($record);
                }
                // hay dos
                else {
                    $record_back = $records[$i + 1];
                    if ($record->type == 'out' && $record_back->type == 'in') {

                        $ra = $record_back->created_at->toDateTimeString();
                        $rc = $record->created_at->toDateTimeString();
                        $rb = $this->timeElapsedString($rc, false, new \DateTime($ra));
                        $rb = 'Estuvo en el estacionamiento ' . str_replace('Hace ', '', $rb);
                        $place_name = $record_back->place_name;
                        $place_address = $record_back->place_address;
                        $id_record = $record_back->id;
                        $id_place = $record_back->id_place;
                        $floor = $record_back->floor;
                        $letter = $record_back->letter;
                        $number = $record_back->number;

                        $history[] = compact('ra', 'rb', 'rc', 'id_record', 'id_place', 'place_name', 'place_address', 'floor', 'letter', 'number');
                    } else {
                        $history[] = $this->getHistoryItem($record_back);
                        $history[] = $this->getHistoryItem($record);
                    }
                }
            }
        }
        return $history;
    }
    public function getLastHistory(int $id_car): array{
        $list = $this->getHistory($id_car);
        if(empty($list)){
            return [];
        }
        return current($list);
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
            ->where('records.do', 1)
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
            $this->insert($id_car, $id_place, 'no-registered', False);
            if($this->satService->existPlate($plate)){
                return json_encode([
                    'status' => 'danger',
                    'message' => 'cuidado es un carro requisitoreado.'
                ]);
            }

            return json_encode([
                'status' => 'error',
                'message' => 'no esta registrado, no puede ingresar.'
            ]);
        }

        // Si existe la placa se guarda como ingresando
        $this->insert($car->id, $id_place, 'in', false);
        return json_encode([
            'status' => 'success',
            'message' => 'falta que escanee QR para ingresar'
        ]);
    }
    public function registerCarExit(int $id_place, string $plate){
        $this->carService->saveDefaultCar($plate);
        $car = $this->carService->getCarWithUser($plate);
        if(is_null($car)){
            return json_encode([
                'status' => 'error',
                'message' => 'no esta registrado, no puede salir.'
            ]);
        }

        $hasPlaceDefined = $this->placeService->hasPlaceDefined($car->id);
        if(!$hasPlaceDefined){
            return json_encode([
                'status' => 'error',
                'message' => 'falta que guarde la ubicacion donde parqueo su carro, no puede salir.'
            ]);
        }
        // Si existe la placa se guarda como saliendo
        $this->insert($car->id, $id_place, 'out', true);
        return json_encode([
            'status' => 'success',
            'message' => 'puede salir'
        ]);
    }
    private function insert(int $id_car, int $id_place, string $type, bool $do){
        $record = new Record();
        $record->id_car = $id_car;
        $record->id_place = $id_place;
        $record->type = $type;
        $record->do = $do;
        $this->recordModel->insert($record);
    }
    /*private function save(int $id_car, int $id_place, string $type, bool $do){
        $record = $this->recordModel
                        ->where('id_car', $id_car)
                        ->orderBy('id', 'DESC')
                        ->first();
        if(is_null($record)) {
            $record = new Record();
        }
        $record->id_car = $id_car;
        $record->id_place = $id_place;
        $record->type = $type;
        $record->do = $do;
        if($record->hasChanged()) {
            $this->recordModel->save($record);
        }
    }*/
    public function getRecordById(int $id_record){
        return $this->recordModel->select(['records.*', 'cars.plate'])->join('cars', 'cars.id = records.id_car')->find($id_record);
    }
    public function updateDoTrue(int $id_place, string $plate){
        $record = model('records')
            ->join('cars', 'cars.id = records.id_car')
            ->where('records.id_place', $id_place)
            ->where('cars.plate', $plate)
            ->orderBy('records.updated_at', 'DESC')
            ->first();
        $this->updateDo($record->id, true);
    }
    public function updateDo(int $id_record, bool $do){
        $record = $this->getRecordById($id_record);
        $record->do = $do;
        if($record->hasChanged()){
            $this->recordModel->save($record);
            return true;
        }
        return false;
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
    public function getLastWithDoEnter(int $id_place, bool $do){
        $result = $this->recordModel
            ->where('id_place', $id_place);
            //->where('type', 'in');
        if($do){
            $result = $result
                ->where('do', 1)
                ->where('DATE_ADD(`updated_at`, interval 30 second) >', 'NOW()', false);
        } else {
            $result = $result
                ->where('do', 0)
                ->where('DATE_ADD(`updated_at`, interval 2 minute) >', 'NOW()', false);
        }
        $result = $result->orderBy('updated_at', 'DESC')->first();
        if(!is_null($result)) {
            $car = $this->carService->getById($result->id_car);
            $plate = $result->plate = $car->plate;
            if(!$do) {
                $_car = $this->carService->getCarWithUser($plate);

                if (is_null($_car)) {

                    $date = $result->updated_at->toDateTimeString();
                    $init = strtotime($date);
                    $finish = strtotime($date.' +10 seconds');
                    if( !((time() >= $init) && (time() <= $finish)) )
                        return null;

                    if ($this->satService->existPlate($plate)) {
                        $result->status = 'danger';
                        $result->message = 'Cuidado es un carro requisitoreado';
                    }

                    $result->status = 'error';
                    $result->message = 'No esta registrado, no puede ingresar';
                }
            }
        }
        return $result;
    }
}