<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    private function cleanList($list){
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
    private function time_elapsed_string($datetime, $full = false, $now = new \DateTime) {
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
    private  function cleanGreaterList($list){
        $list = array_map(function($data){
            $date = $data->updated_at->toDateTimeString();
            $init = strtotime($date);
            $finish = strtotime($date.' +24 hours');
            $data->toomuch = !((time() >= $init) && (time() <= $finish));
            $data->toago = $this->time_elapsed_string($date);

            $date = strtotime($date.' +2 minutes');
            if ( time() >= $date )
                return $data;
            return;
        }, $list);
        $list = array_filter($list);
        return $list;
    }
    public function getUsers(string $type, int $id_user = null){
        $data = [];
        switch ($type){
            case 'list':
                $a = model('Users')
                    ->select([
                        'users.*',
                        'cars.id as id_car', 'cars.plate', 'cars.color'
                    ])
                    ->join('cars', 'users.id = cars.id_user')
                    ->findAll();
                $b = model('Users')
                    ->select([
                        'users.*'
                    ])
                    ->where('type', 'seguridad')
                    ->findAll();

                $registered_plates = array_merge($a, $b);
                $data["registered_plates"] = $registered_plates;
                break;
            case 'update':
            case 'view':
                $model = model('Users');
                $data['user'] = $model->join('cars', 'users.id = cars.id_user')->find($id_user);
                print_r($data['user']);
                die;
                if($this->request->getMethod() == 'POST'){
                    return redirect()->to('user/list');
                }
                return view("user-create", $data);
            case 'create':
                if(!is_null($id_user)) {
                    $model = model('Users');
                    $data['user'] = $model->join('cars', 'users.id = cars.id_user')->find($id_user);
                    print_r($data['user']);
                    die;
                }
                if($this->request->getMethod() == 'POST'){
                    return redirect()->to('user/list');
                }
                break;
            case 'delete':
                die;
                break;
        }
        if(!is_null($id_user)){
            $type = 'create';
            echo "ASD";
            die;
        }
        return view("user-{$type}", $data);
    }
    public function getPlatesNoRegistered(){
        $cars = model('Cars');
        $con_rq = $cars->select([
                'records.*',
                'cars.plate',
                'COUNT(records.id_car) as count',
                'MAX(records.updated_at) as updated_at'
            ])
            ->join('records', 'records.id_car = cars.id')
            ->join('sat', 'sat.plate = cars.plate')
            ->where('id_user', NULL)
            ->where('type', 'no-registered')
            ->groupBy('records.id_car')
            ->findAll();

        $con_rq = array_map(function($item){
            $item->rq = true;
            return $item;
        }, $con_rq);
        $ids = array_column($con_rq, 'id_car');

        $sin_rq = $cars->select([
            'records.*',
            'cars.plate',
            'COUNT(records.id_car) as count',
            'MAX(records.updated_at) as updated_at'
        ])->join('records', 'records.id_car = cars.id');
        if(!empty($ids)){
            $sin_rq = $sin_rq->whereNotIn('records.id_car', $ids);
        }
        $sin_rq = $sin_rq->where('id_user', NULL)
            ->where('type', 'no-registered')
            ->groupBy('records.id_car')
            ->findAll();
        $sin_rq = array_map(function($item){
            $item->rq = false;
            return $item;
        }, $sin_rq);
        $no_registered_plates = array_merge($sin_rq, $con_rq);
        $data["no_registered_plates"] = $no_registered_plates;
        return view('no-registered', $data);
    }
    public function getMonitoring(){
        if(is_null(session()->get('user')))
            return redirect()->to('/login');

        $records = model('Records');
        $session = session()->get('user');
        if($session['type'] == 'seguridad') {
            $car_entering = $records
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
            $car_entering = $this->cleanList($car_entering);

            $in_parking = $records
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
            $in_parking = $this->cleanGreaterList($in_parking);
            $car_leaving = $records
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
            $car_leaving = $this->cleanList($car_leaving);

            $data = compact('car_entering', 'in_parking', 'car_leaving');

            return view('centro-control', $data);
        } else {
            $session = session()->get('user');
            $car = model('Cars')->where('id_user', $session['id'])->first();
            return $this->getUserHistory($session['id']);
        }

    }
    public function getUserHistory(int $id_user){
        $car = model('Cars')->where('id_user', $id_user)->first();
        $data['car'] = $car;
        $records = model("Records")
            ->where('id_car', $data['car']->id)
            ->orderBy('id', 'DESC')
            ->findAll();

        $historial = [];
        $i = 0;
        if(count($records) > 0) {
            for ($i = 0; $i - 1 < count($records); $i += 2) {
                $ra = $records[$i]->created_at->toDateTimeString();
                $rc = [];
                if (isset($records[$i + 1])) {
                    $rc = $records[$i + 1]->created_at->toDateTimeString();
                    $rb = $this->time_elapsed_string($rc, false, new \DateTime($ra));
                    $rb = 'Estuvo en el estacionamiento ' . str_replace('Hace ', '', $rb);
                } else {
                    $rc = '';
                    $rb = $this->time_elapsed_string(date('Y-m-d H:i:s'), false, new \DateTime($ra));
                    $rb = 'Está en el estacionamiento ' . strtolower($rb);
                }
                $historial[] = compact('ra', 'rb', 'rc');
            }
        }
        $data['historial'] = $historial;
        return view('historial', $data);
    }
}
