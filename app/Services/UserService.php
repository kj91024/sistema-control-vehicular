<?php
namespace App\Services;
use App\Entities\User;
use App\Models\Users;
use CodeIgniter\HTTP\RedirectResponse;

class UserService{
    protected Users $userModel;
    protected CarService $carService;
    public function __construct(){
        $this->userModel = model('Users');
        $this->carService  = new CarService();
    }
    public function findByParams(array $params): ?User{
        extract($params);
        $user = $this->userModel
            ->where('username', $username)
            ->orWhere('dni', $dni)
            ->orWhere('license_number', $license_number)
            ->first();
        return $user;
    }
    public function findByUsername(string $username): ?User{
        $user = $this->userModel
            ->where('username', $username)
            ->first();
        return $user;
    }
    public function existUser(array $data): bool{
        if ($data['type'] != 'seguridad') {
            $params = [
                'username' => $data['username'],
                'dni' => $data['dni'],
                'license_number' => $data['license_number']
            ];
            $user = $this->findByParams($params);
        } else {
            $user = $this->findByUsername($data['username']);
        }
        return is_null($user);
    }
    public function createUser(array $data){
        // Consultamos la existencia del usuario
        if(!$this->existUser($data)){
            return redirect()->back()->with('error', "Estos datos ya existen");
        }

        // Creamos al existencia del usuario
        $user = new User();
        $user->dni = $data['dni'];
        $user->first_names = ucwords($data['first_names']);
        $user->last_names = ucwords($data['last_names']);
        $user->cellphone = $data['cellphone'];
        $user->type = $data['type'];
        $user->username = $data['username'];
        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->license_number = $data['license_number'] ?? 0;

        if($user->hasChanged()){
            $this->userModel->save($user);
            $id_user = $this->userModel->insertID;
        }

        if(is_null($id_user)){
            return redirect()->back()->with('error', "No se pudo crear el usuario");
        }

        if($data['type'] != 'seguridad') {
            # Añadimos al carro
            $carService = new CarService();
            $carService->createCar($id_user, $data);
        }
        return $id_user;
    }
    function updateUser(array $data, $id_user){
        $user = $this->userModel->find($id_user);
        $user->type = $data['type'];
        $user->first_names = $data['first_names'];
        $user->last_names = $data['last_names'];
        $user->dni = $data['dni'];
        $user->cellphone = $data['cellphone'];
        $user->username = $data['username'];
        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->license_number = $data['license_number'];
        
        if($user->hasChanged()){
            $this->userModel->save($user);
        }

        if($data['type'] != 'seguridad') {
            $this->carService->updateCar($data, $id_user);
        }

        return true;
    }
    public function getUserList(){
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

        return array_merge($a, $b);
    }
}