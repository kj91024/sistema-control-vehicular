<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    public function cleanList($list){
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
    private function time_elapsed_string($datetime, $full = false) {
        $now = new \DateTime;
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
    public function cleanGreaterList($list){
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
    public function index()
    {
        if(is_null(session()->get('user')))
            return redirect()->to('/login');

        $cars = model('Cars');
        $records = model('Records');

        $registered_plates = $cars
            ->join('users','users.id = cars.id_user')
            ->orderBy('cars.created_at','DESC')
            ->findAll();

        $car_entering = $records
            ->select([
                'cars.plate', 'cars.color',
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
                'cars.plate', 'cars.color',
                'users.dni', 'users.first_names', 'users.last_names', 'users.cellphone',
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
                'cars.plate', 'cars.color',
                'users.dni', 'users.first_names', 'users.last_names', 'users.cellphone',
                'records.created_at', 'records.updated_at'
            ])
            ->join('cars', 'cars.id = records.id_car')
            ->join('users', 'users.id = cars.id_user')
            ->where('records.type', 'out')
            ->orderBy('records.updated_at','DESC')
            ->findAll();
        $car_leaving = $this->cleanList($car_leaving);

        $no_registered_plates = $cars->where('id_user', NULL)->findAll();
        $data = compact('registered_plates', 'car_entering', 'in_parking', 'car_leaving', 'no_registered_plates');
        #print_r($data);die;
        return view('dashboard', $data);
    }
}
