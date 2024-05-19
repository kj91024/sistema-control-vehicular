<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Car;
use App\Entities\Record;
use App\Entities\User;
use App\Models\Records;
use App\Services\PlaceService;
use App\Services\RecordService;
use CodeIgniter\HTTP\ResponseInterface;

class Api extends BaseController
{
    protected RecordService $recordService;
    protected PlaceService $placeService;
    public function __construct(){
        header('Access-Control-Allow-Origin: *');
        $this->recordService = new RecordService();
        $this->placeService = new PlaceService();
    }
    private function check(string $plate): bool
    {
        return strlen($plate) == 7
                && !empty(preg_grep("#([A-Z0-9]+){3}-([0-9]+){3}#", [$plate]));
    }
    private function checkToken(){
        $token = $this->request->getGet('token');
        $id_place = decrypt($token);
        $place = $this->placeService->getPlaceById($id_place);
        if(is_null($place)){
            return json_encode([
                'status' => 'error',
                'message' => 'Token invalido.'
            ]);
        }
        return true;
    }
    private function checkSignature(){
        $signature = $this->request->getGet('signature');
        $signature = base64_decode($signature);
        $current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if(strpos($current_url, $signature) != 0){
            return json_encode([
                'status' => 'error',
                'message' => 'Firma invalida.'
            ]);
        }
        return true;
    }

    /*
    register/1/ASD-123
    in/1/ASD-123
    out/1/ASD-123
    */
    public function in(int $id_place, string $plate)
    {
        if(!$this->check($plate)) {
            die(json_encode([
                'status' => 'error',
                'message' => 'Formato de placa incorrecta, no puede ingresar.'
            ]));
        }

        if(($value = $this->checkToken()) !== true)         die($value);
        if(($value = $this->checkSignature()) !== true)     die($value);

        die($this->recordService->registerCarEntry($id_place, $plate));
    }
    /*public function in(int $id_place, string $plate){
        if(!$this->check($plate)) {
            die(json_encode([
                'status' => 'error',
                'message' => 'Formato de placa incorrecta, no puede ingresar.'
            ]));
        }

        if(($value = $this->checkToken()) !== true)         die($value);
        if(($value = $this->checkSignature()) !== true)     die($value);

        $this->recordService->updateDoTrue($id_place, $plate);

        return json_encode([
            'status' => 'success',
            'message' => 'Puede ingresar'
        ]);
    }*/
    public function out(int $id_place, string $plate)
    {
        if(!$this->check($plate)) {
            die(json_encode([
                'status' => 'error',
                'message' => 'Formato de placa incorrecta, no puede salir.'
            ]));
        }

        if(($value = $this->checkToken()) !== true)         die($value);
        if(($value = $this->checkSignature()) !== true)     die($value);

        die($this->recordService->registerCarExit($id_place, $plate));
    }
    public function info($token){
        $data['status'] = "error";
        $data['data'] = 'Token de enlace incorrecto';

        $id_place = decrypt($token);
        $place = $this->placeService->getPlaceAvailable($id_place);
        if(empty($place))
            die(json_encode($data));
        /*
        $places = $this->placeService->getPlacesAvailable();
        foreach($places as $place)
            if($place->id == $id_place) break;

        if($place->id != $id_place)
            die(json_encode($data));
        */
        $place->floor = json_decode($place->floor);
        $data['status'] = "success";
        $data['data'] = $place;
        die(json_encode($data));
    }
    public function getData(int $id_place){
        $place = $this->placeService->getPlaceAvailable($id_place);
        $record_to_enter = $this->recordService->getLastWithDoEnter($id_place, 0);
        $record_in = $this->recordService->getLastWithDoEnter($id_place, 1);

        if(is_null($record_to_enter) && is_null($record_in)){
            $step = 1;
        } else if(is_null($record_in)) {
            $step = 2;
        } else {
            $step = 3;
        }

        die(json_encode(compact('step', 'place', 'record_to_enter', 'record_in')));
    }
    public function updateDo(int $id_place, string $plate){
        $record = model('Records')
            ->select(['records.*'])
            ->join('cars', 'cars.id = records.id_car')
            ->where('id_place', $id_place)
            ->where('type', 'in')
            ->where('cars.plate', $plate)
            ->orderBy('records.updated_at', 'DESC')->first();
        $id_record = $record->id;
        $this->recordService->updateDo($id_record, true);
        return redirect()->to('/');
    }
}