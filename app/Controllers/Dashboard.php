<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Place;
use App\Entities\User;
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
        'place_name' => [
            'rules'  => 'required|max_length[200]',
            'errors' => [
                'required' => 'Debe ingresar el nombre del parking para identificarlo',
                'max_length[200]' => 'Debe tener menos de 200 caracteres',
            ]
        ],
        'place_address' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Debe ingresar la dirección',
            ]
        ],
        'spaces' => [
            'rules'  => 'required|integer',
            'errors' => [
                'required' => 'Debe ingresar el espacio',
                'integer' => 'Debe ingresar con cuantos espacios cuenta el parking',
            ]
        ]
    ];
    protected array $userRules = [
        'dni' => [
            'rules'  => 'required|integer|max_length[8]',
            'errors' => [
                'required' => 'Es necesario ingresar tu DNI',
                'integer' => 'Debes ingresar un número',
                'max_length[8]' => 'Debe tener 8 dígitos',
            ]
        ],
        'first_names' => [
            'rules'  => 'required|max_length[30]',
            'errors' => [
                'required' => 'Debes ingresar tus nombres',
                'max_length[30]' => 'Debes ingresar 30 letras en nombres'
            ]
        ],
        'last_names' => [
            'rules'  => 'required|max_length[30]',
            'errors' => [
                'required' => 'Debes ingresar tus apellidos',
                'max_length[30]' => 'Debes ingresar 30 letras en apellidos',
            ]
        ],
        'username' => [
            'rules'  => 'required|max_length[30]',
            'errors' => [
                'required' => 'Debes ingresar tu nombre de usuario',
                'max_length[11]' => 'El máximo de dígitos es 30',
            ]
        ],
        'password' => [
            'rules'  => 'required|max_length[30]',
            'errors' => [
                'required' => 'Debes ingresar tu contraseña',
                'max_length[20]' => 'El máximo de dígitos es 30',
            ]
        ],
        're_password' => [
            'rules'  => 'required|max_length[20]',
            'errors' => [
                'required' => 'Debes ingresar tu contraseña nuevamente',
                'max_length[20]' => 'El máximo de dígitos es 30',
            ]
        ]
    ];
    protected array $carRules = [
        'license_number' => [
            'rules'  => 'required|max_length[11]',
            'errors' => [
                'required' => 'Debes ingresar tu número de licencia',
                'max_length[11]' => 'El máximo de dígitos es 11',
            ]
        ],
        'plate' => [
            'rules'  => 'required|max_length[7]',
            'errors' => [
                'required' => 'Debes ingresar tu número de placa',
                'max_length[11]' => 'El máximo de dígitos es 7',
            ]
        ],
        'color' => [
            'rules'  => 'required|max_length[7]',
            'errors' => [
                'required' => 'Es necesario ingresar el color',
                'max_length[7]' => 'Debes ingresar el # y color'
            ]
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
                if($this->request->getMethod() == 'POST'){
                    $data = $this->request->getPost();
                    if (!$this->validateData($data, $this->userRules)) {
                        return redirect()->back()->withInput();
                    }
                    if ($data['type'] != 'seguridad' && !$this->validateData($data, $this->carRules)) {
                        return redirect()->back()->withInput();
                    }
                    if($data['password'] != $data['re_password']){
                        return redirect()->back()->with('error', "Las contraseñas no son iguales");
                    }
                    $this->userService->updateUser($data, $id_user);
                    return redirect()->back();
                }
            case 'view':
                $model = model('Users');
                $data['user'] = $model->join('cars', 'users.id = cars.id_user')->find($id_user);
                if($this->request->getMethod() == 'POST'){
                    return redirect()->to('user/list');
                }
                return view("user-create", $data);
            case 'create':
                $user = new User();
                if(!is_null($id_user)) {
                    $model = model('Users');
                    $data['id_user'] = $id_user;
                    $user = $model->join('cars', 'users.id = cars.id_user')->find($id_user);
                }
                $data['user'] = $user;
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

        $places = $this->placeService->getPlacesAvailable();
        if($this->userSession['type'] == 'seguridad') {
            $car_entering = $this->recordService->getCarsEntering();
            $in_parking = $this->recordService->getCarsInParking();
            $car_leaving = $this->recordService->getCarsLeaving();
            $data = compact('places', 'car_entering', 'in_parking', 'car_leaving');
            return view('centro-control', $data);
        } else {

            $record = $is_save = $code = $places_available = null;
            $out = $read_qr = false;

            $car = $this->carService->findByIdUser($this->userSession['id']);
            $last_history = $this->recordService->getLastHistory($car->id);
            if(!empty($last_history)){
                $record = $this->recordService->getRecordById($last_history['id_record']);
                $record_to_enter = $this->recordService->getLastWithDoEnter($record->id_place, 0);
                $read_qr = !is_null($record_to_enter) && $record_to_enter->type == 'in' && $record_to_enter->id_car == $car->id;
                $is_save = !(empty($record->floor) || empty($record->letter) || empty($record->number));
                $code = $record->floor.'|'.$record->letter.'|'.$record->number;
                $places_available = $this->placeService->getFloorLevelAvailable($last_history['id_place']);
                $out = $record->type == 'in' && $record->do == 1;
            }

            $data = compact('code', 'places', 'read_qr', 'car', 'record', 'last_history', 'places_available', 'out', 'is_save');
            return view('dashboard', $data);
        }
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
                $data['place'] = new Place;
                if($this->request->getMethod() == 'POST'){
                    $data = $this->request->getPost();
                    if (!$this->validateData($data, $this->placeRules)) {
                        return redirect()->back()->withInput();
                    }
                    if(!is_null($id_place)){
                        $data['id'] = $id_place;
                    }

                    $floor = $data['floor'];
                    foreach($floor as &$item){
                        $item['levels'] = empty($item['levels']) ? 0 : $item['levels'];
                        $item['places_quantity'] = empty($item['places_quantity']) ? 0 : $item['places_quantity'];
                        $item['place_letter'] = empty($item['place_letter']) ? [] : $item['place_letter'];
                    }
                    $data['floor'] = $floor;

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
            case 'delete':
                $this->placeService->deletePlace($id_place);
                return redirect()->to(base_url('parking/list'));
            case 'view':
                $place_available = $this->placeService->getFloorLevelAvailableFull($id_place);
                $data['place_available'] = $place_available;
        }

        return view("place-{$type}", $data);
    }
    public function updatePlace(string $id_record){
        $rule = [
            'place' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Debe seleccionar el lugar donde se ha estacionado'
                ]
            ]
        ];
        $data = $this->request->getPost();
        if (!$this->validateData($data, $rule)) {
            return redirect()->back()->withInput();
        }

        $this->recordService->updatePlace($id_record, $data['place']);
        return redirect()->back();
    }
    public function getSecondaryWindow(){
        $data = $this->request->getGet();
        if(empty($data) or empty($data['signature'])){
            return redirect()->to(base_url(''));
        }
        $data = urldecode($data['signature']);
        $data = base64_decode($data);
        $data = json_decode($data);
        if(empty($data)){
            return redirect()->to(base_url(''));
        }
        $place = $this->placeService->getPlaceAvailable($data->id);
        return view('secondary_window', compact('place'));
    }
    public function scanQR(int $id_record){
        $record = $this->recordService->getRecordById($id_record);
        $plate = $record->plate;
        $data = compact('id_record', 'plate');
        return view('scanner', $data);
    }
    public function readyScanQR(){
        $record_to_enter = $this->recordService->getLastWithDoEnter($record->id_place, 0);
        print_r($record_to_enter);die;
    }
    public function updateDo(int $id_record){
        $this->recordService->updateDo($id_record, true);
        return redirect()->to('/');
    }
}
