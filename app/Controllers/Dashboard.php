<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Place;
use App\Services\CarService;
use App\Services\PlaceService;
use App\Services\RecordService;
use App\Services\UserService;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    protected RecordService $recordService;
    protected CarService $carService;
    protected UserService $userService;
    protected PlaceService $placeService;
    protected array $userSession;
    protected array $placeRules = [
        'name' => [
            'rules'  => 'required|max_length[200]',
            'errors' => [
                'required' => 'Debe ingresar el nombre del parking para identificarlo',
                'max_length[200]' => 'Debe tener menos de 200 caracteres',
            ],
        ],
        'address' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Debe ingresar la dirección',
            ],
        ],
        'spaces' => [
            'rules'  => 'required|integer',
            'errors' => [
                'required' => 'Debe ingresar el espacio',
                'integer' => 'Debe ingresar con cuantos espacios cuenta el parking',
            ],
        ]
    ];

    public function __construct(){
        $this->userSession   = session()->has('user') ? session()->get('user') : [];
        $this->userService   = new UserService();
        $this->recordService = new RecordService();
        $this->carService    = new CarService();
        $this->placeService  = new PlaceService();
    }
    public function getUsers(string $type, int $id_user = null){
        $data = [];
        switch ($type){
            case 'list':
                $data["registered_plates"] = $this->userService->getUserList();
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
    public function getPlatesNoRegistered(): string
    {
        $data["no_registered_plates"] = $this->recordService->getPlatesNoRegistered();
        return view('no-registered', $data);
    }
    public function getMonitoring(): string|RedirectResponse
    {
        if (is_null(session()->get('user'))){
            return redirect()->to('/login');
        }

        if($this->userSession['type'] != 'seguridad') {
            return $this->getUserHistory($this->userSession['id']);
        }

        $car_entering = $this->recordService->getCarsEntering();
        $in_parking = $this->recordService->getCarsInParking();
        $car_leaving = $this->recordService->getCarsLeaving();

        $data = compact('car_entering', 'in_parking', 'car_leaving');

        return view('centro-control', $data);
    }
    public function getUserHistory(int $id_user): string
    {
        $car = $this->carService->findByIdUser($id_user);
        $historial = $this->recordService->getHistory($car->id);
        $data = compact('car', 'historial');
        return view('historial', $data);
    }
    public function getParking(string $type, int $id_place = null){
        $data = [];
        switch($type){
            case 'add':
                // Añadimos Place
                $data['place'] = new Place;
                if($this->request->getMethod() == 'POST'){
                    $data = $this->request->getPost();
                    if (!$this->validateData($data, $this->placeRules)) {
                        return redirect()->back()->withInput();
                    }
                    if(!is_null($id_place)){
                        $data['id'] = $id_place;
                    }
                    $this->placeService->createPlace($data);
                    return redirect()->to(base_url('parking/list'));
                }
                break;
            case 'list':
                $data['list'] = $this->placeService->getPlaceList();
                break;
            case 'edit':
                $type = 'add';
                $place = $this->placeService->getPlaceById($id_place);
                $data['place'] = is_null($place) ? new Place : $place;
                break;
        }

        return view("place-{$type}", $data);
    }
}
