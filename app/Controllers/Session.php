<?php

namespace App\Controllers;

use App\Services\UserService;
use CodeIgniter\HTTP\RedirectResponse;
use App\Services\SessionService;

class Session extends BaseController
{
    protected array $loginRules = [
        'username' => [
            'rules'  => 'required|max_length[20]',
            'errors' => [
                'required' => 'Debes ingresar tu nombre de usuario',
                'max_length[20]' => 'El máximo de dígitos es 11',
            ],
        ],
        'password' => [
            'rules'  => 'required|max_length[20]',
            'errors' => [
                'required' => 'Debes ingresar tu contraseña',
                'max_length[20]' => 'El máximo de dígitos es 11',
            ],
        ]
    ];
    protected array $registerRules = [
        'dni' => [
            'rules'  => 'required|integer|max_length[8]',
            'errors' => [
                'required' => 'Es necesario ingresar tu DNI',
                'integer' => 'Debes ingresar un número',
                'max_length[8]' => 'Debe tener 8 dígitos',
            ],
        ],
        'first_names' => [
            'rules'  => 'required|max_length[30]',
            'errors' => [
                'required' => 'Debes ingresar tus nombres',
                'max_length[30]' => 'Debes ingresar 30 letras en nombres'
            ],
        ],
        'last_names' => [
            'rules'  => 'required|max_length[30]',
            'errors' => [
                'required' => 'Debes ingresar tus apellidos',
                'max_length[30]' => 'Debes ingresar 30 letras en apellidos',
            ],
        ],
        'username' => [
            'rules'  => 'required|max_length[30]',
            'errors' => [
                'required' => 'Debes ingresar tu nombre de usuario',
                'max_length[11]' => 'El máximo de dígitos es 30',
            ],
        ],
        'password' => [
            'rules'  => 'required|max_length[30]',
            'errors' => [
                'required' => 'Debes ingresar tu contraseña',
                'max_length[20]' => 'El máximo de dígitos es 30',
            ],
        ],
        're_password' => [
            'rules'  => 'required|max_length[20]',
            'errors' => [
                'required' => 'Debes ingresar tu contraseña nuevamente',
                'max_length[20]' => 'El máximo de dígitos es 30',
            ],
        ]
    ];
    protected array $carRules = [
        'license_number' => [
            'rules'  => 'required|max_length[11]',
            'errors' => [
                'required' => 'Debes ingresar tu número de licencia',
                'max_length[11]' => 'El máximo de dígitos es 11',
            ],
        ],
        'plate' => [
            'rules'  => 'required|max_length[7]',
            'errors' => [
                'required' => 'Debes ingresar tu número de placa',
                'max_length[11]' => 'El máximo de dígitos es 7',
            ],
        ],
        'color' => [
            'rules'  => 'required|max_length[7]',
            'errors' => [
                'required' => 'Es necesario ingresar el color',
                'max_length[7]' => 'Debes ingresar el # y color'
            ],
        ]
    ];
    protected SessionService $sessionService;
    protected UserService $userService;
    public function __construct(){
        $this->sessionService = new SessionService();
        $this->userService = new UserService();
    }
    private function validateLogin(array $data){
        if(!is_null(session()->get('user')))
            return redirect()->to('/');

        if($this->request->getMethod() == 'GET')
            return view('login');

        if (! $this->validateData($data, $this->loginRules)) {
            return redirect()->back()->withInput();
        }
        return true;
    }
    private function validateRegister(array $data){
        if(!is_null(session()->get('user')))
            return redirect()->to('/');
        if($this->request->getMethod() == 'GET')
            return view('register');


        if (!$this->validateData($data, $this->registerRules)) {
            return redirect()->back()->withInput();
        }
        if ($data['type'] != 'seguridad' && !$this->validateData($data, $this->carRules)) {
            return redirect()->back()->withInput();
        }
        if($data['password'] != $data['re_password']){
            return redirect()->back()->with('error', "Las contraseñas no son iguales");
        }

        return true;
    }
    public function login() : string|RedirectResponse
    {
        $data = $this->request->getPost();
        $validated = $this->validateLogin($data);
        if($validated !== true){
            return $validated;
        }

        $login = (new SessionService())
                    ->loginUser($data['username'], $data['password']);

        return $login === true
                ? redirect()->to('/')
                : $login;
    }
    public function register(): string|RedirectResponse
    {
        $data = $this->request->getPost();
        $data['type'] = $data['type'] ?? 'alumno';
        $validated = $this->validateRegister($data);
        if($validated !== true){
            return $validated;
        }
        # Añadimos al usuario
        $response = $this->userService->createUser($data);
        if($response instanceof RedirectResponse){
            return $response;
        }

        if($data['type'] == 'alumno') {
            return redirect()->to('/login')->with('success', "Usuario registrado, puedes iniciar sesión");
        } else {
            return redirect()->to('/user/list');
        }
    }
    public function logout(): RedirectResponse
    {
        $this->sessionService->deleteSession();
        return redirect()->to('/');
    }
}
