<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Car;
use App\Entities\User;
use CodeIgniter\HTTP\ResponseInterface;

class Session extends BaseController
{
    protected $loginRules = [
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
    protected $registerRules = [
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
            'rules'  => 'required|max_length[11]',
            'errors' => [
                'required' => 'Debes ingresar tu nombre de usuario',
                'max_length[11]' => 'El máximo de dígitos es 11',
            ],
        ],
        'password' => [
            'rules'  => 'required|max_length[20]',
            'errors' => [
                'required' => 'Debes ingresar tu contraseña',
                'max_length[20]' => 'El máximo de dígitos es 11',
            ],
        ],
        're_password' => [
            'rules'  => 'required|max_length[20]',
            'errors' => [
                'required' => 'Debes ingresar tu contraseña nuevamente',
                'max_length[20]' => 'El máximo de dígitos es 11',
            ],
        ],
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
    public function login()
    {
        if(!is_null(session()->get('user')))
            return redirect()->to('/');

        if($this->request->getMethod() == 'GET')
            return view('login');

        $data = $this->request->getPost();
        if (! $this->validateData($data, $this->loginRules)) {
            return redirect()->back()->withInput();
        }

        $user = model('Users')
            ->where('username', $data['username'])
            ->first();
        if( is_null($user) ){
            return redirect()->back()->with('error', 'No existe este usuario');
        }
        if( !password_verify($data['password'], $user->password) ){
            return redirect()->back()->with('error', 'Contraseña incorrecta');
        }

        $user = [
            'id' => $user->id,
            'dni' => $user->dni,
            'first_names' => $user->first_names,
            'last_names' => $user->last_names,
            'cellphone' => $user->cellphone,
            'type' => $user->type,
            'username' => $user->username,
            'license_number' => $user->license_number,
        ];

        session()->set('user', $user);
        return redirect()->to('/');
    }
    public function register()
    {
        if(!is_null(session()->get('user')))
            return redirect()->to('/');

        if($this->request->getMethod() == 'GET')
            return view('register');

        $data = $this->request->getPost();
        if (! $this->validateData($data, $this->registerRules)) {
            //print_r($this->validator->getErrors());die;
            return redirect()->back()->withInput();
        }

        if($data['password'] != $data['re_password']){
            return redirect()->back()->with('error', "Las contraseñas no son iguales");
        }
        $model = model('Users');
        $user = $model
                    ->where('username', $data['username'])
                    ->orWhere('dni', $data['dni'])
                    ->orWhere('license_number', $data['license_number'])
                    ->first();
        if(!is_null($user)){
            return redirect()->back()->with('error', "Estos datos ya existen");
        }

        $id_user = null;

        # Añadimos al usuario
        $user = new User();
        $user->dni = $data['dni'];
        $user->first_names = $data['first_names'];
        $user->last_names = $data['last_names'];
        $user->cellphone = $data['cellphone'];
        $user->type = 'user';
        $user->username = $data['username'];
        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->license_number = $data['license_number'];
        if($user->hasChanged()){
            $id_user = $model->save($user);
        }

        if(is_null($id_user)){
            return redirect()->back()->with('error', "No se pudo crear el usuario");
        }

        # Añadimos al carro
        $model = model('Cars');
        $car = $model
                    ->where('plate', $data['plate'])
                    ->first();
        if( is_null($car) or is_null($car->id_user) ) {
            $car = new Car();
            $car->id_user = $id_user;
            $car->plate = $data['plate'];
            $car->color = $data['color'];
            if ($car->hasChanged()) {
                $model->save($car);
            }
        }
        return redirect()->to('/login')->with('success', "Usuario registrado, puedes iniciar sesión");
    }
    public function logout()
    {
        session()->remove('user');
        return redirect()->to('/');
    }
}
