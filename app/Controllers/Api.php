<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Car;
use App\Entities\Record;
use App\Entities\User;
use App\Models\Records;
use App\Services\RecordService;
use CodeIgniter\HTTP\ResponseInterface;

class Api extends BaseController
{
    protected RecordService $recordService;
    public function __construct(){
        $this->recordService = new RecordService();
    }
    private function check(string $plate): bool
    {
        return strlen($plate) == 7
                && !empty(preg_grep("#([A-Z0-9]+){3}-([0-9]+){3}#", [$plate]));
    }
    private function checkToken(){
        $token = md5('utp');
        $_token = $this->request->getGet('token');
        if($token != $_token){
            return json_encode([
                'status' => 'error',
                'message' => 'Token inválido.'
            ]);
        }
        return true;
    }
    public function in(int $id_place, string $plate)
    {
        if(!$this->check($plate)) {
            return json_encode([
                'status' => 'error',
                'message' => 'Formato de placa incorrecta, no puede ingresar.'
            ]);
        }

        if(($value = $this->checkToken()) !== true){
            return $value;
        }

        return $this->recordService->registerCarEntry($id_place, $plate);
    }
    public function out(int $id_place, string $plate)
    {
        if(!$this->check($plate)) {
            return json_encode([
                'status' => 'error',
                'message' => 'Formato de placa incorrecta, no puede salir.'
            ]);
        }

        if(($value = $this->checkToken()) !== true){
            return $value;
        }

        return $this->recordService->registerCarExit($id_place, $plate);
    }
}
