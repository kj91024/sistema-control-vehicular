<?php
namespace App\Services;
use App\Entities\Car;
use App\Models\Cars;

class CarService{
    protected Cars $carModel;
    public function __construct(){
        $this->carModel = model("Cars");
    }

    public function findByPlate(string $plate): ?Car{
        $car = $this->carModel
                ->where('plate', $plate)
                ->first();
        return $car;
    }
    public function findByIdUser(int $id_user): ?Car{
        $car = $this->carModel
                ->where('id_user', $id_user)
                ->first();
        return $car;
    }
    public function createCar(int $id_user, array $data){
        // Verificamos la existencia de la placa
        $car = $this->findByPlate($data['plate']);
        if (!is_null($car) and !is_null($car->id_user))
            return false;

        return $this->create($data, $id_user);
    }
    public function saveDefaultCar($plate): int{
        $car = $this->findByPlate($plate);
        if(is_null($car)){
            $data = compact('plate');
            $id_car = $this->create($data);
        }
        return is_null($car) ? $id_car : $car->id;
    }
    private function create(array $data, $id_user = null){
        $id_car = null;

        // Agregamos el carro
        $car = new Car();
        foreach($data as $column => $value ){
            $car->$column = $value;
        }
        if($id_user != null)
            $car->id_user = $id_user;

        if ($car->hasChanged()) {
            $this->carModel->save($car);
            $id_car = $this->carModel->getInsertID();
        }
        return $id_car;
    }
    public function getCarWithUser(string $plate){
        $result = $this->carModel
            ->select('cars.id')
            ->join('users', 'users.id = cars.id_user')
            ->where('plate', $plate)
            ->first();
        return $result;
    }
}