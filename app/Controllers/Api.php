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
    public function in(string $plate)
    {
        if(!$this->check($plate)) {
            return json_encode([
                'status' => 'error',
                'message' => 'Formato de placa incorrecta, no puede ingresar.'
            ]);
        }

        return $this->recordService->registerCarEntry($plate);
    }
    public function out(string $plate)
    {
        if(!$this->check($plate)) {
            return json_encode([
                'status' => 'error',
                'message' => 'Formato de placa incorrecta, no puede salir.'
            ]);
        }

        return $this->recordService->registerCarExit($plate);
    }
}
