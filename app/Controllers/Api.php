<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Car;
use App\Entities\Record;
use App\Entities\User;
use App\Models\Records;
use CodeIgniter\HTTP\ResponseInterface;

class Api extends BaseController
{
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

        $model = model('Cars');
        $car = $model
                    ->where('plate', $plate)
                    ->first();

        if(is_null($car)){
            $car = new Car();
            $car->plate = $plate;
            $model->save($car);
        }

        $car = $model
                    ->select('cars.id')
                    ->join('users', 'users.id = cars.id_user')
                    ->where('plate', $plate)
                    ->first();
        if(is_null($car)){
            return json_encode([
                'status' => 'error',
                'message' => 'Carro está en el ingreso pero no está registrado en la base de datos, no puede ingresar.'
            ]);
        } else {
            $model = model('Records');
            $record = $model->where('id_car', $car->id)
                            //->where('type', 'out')
                            ->first();
            if(is_null($record)) {
                $record = new Record();
            }
            $record->id_car = $car->id;
            $record->type = 'in';
            if($record->hasChanged()) {
                $model->save($record);
            }
            return json_encode([
                'status' => 'success',
                'message' => 'Carro está en el ingreso, puede ingresar'
            ]);
        }
    }
    public function out(string $plate)
    {
        if(!$this->check($plate)) {
            return json_encode([
                'status' => 'error',
                'message' => 'Formato de placa incorrecta, no puede salir.'
            ]);
        }
        $model = model('Cars');
        $car = $model
            ->where('plate', $plate)
            ->first();

        if(is_null($car)){
            $car = new Car();
            $car->plate = $plate;
            $model->save($car);
        }

        $car = $model
            ->select('cars.id')
            ->join('users', 'users.id = cars.id_user')
            ->where('plate', $plate)
            ->first();
        if(is_null($car)){
            return json_encode([
                'status' => 'error',
                'message' => 'Carro está en la salida pero no está registrado en la base de datos, no puede salir.'
            ]);
        } else {
            $model = model('Records');
            $record = $model->where('id_car', $car->id)
                //->where('type', 'in')
                ->first();
            if(is_null($record)) {
                $record = new Record();
            }
            $record->id_car = $car->id;
            $record->type = 'out';
            if($record->hasChanged()) {
                $model->save($record);
            }
            return json_encode([
                'status' => 'success',
                'message' => 'Carro está en la salida, puede salir'
            ]);
        }
    }
}
