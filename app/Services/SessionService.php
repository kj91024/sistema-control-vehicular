<?php
namespace App\Services;
use App\Entities\User;

class SessionService {
    protected string $sessionName = "user";
    public function loginUser(string $user, string $password){
        $user = (new UserService())->findByUsername($user);
        if( is_null($user) ){
            return redirect()->back()->with('error', 'No existe este usuario');
        }

        if( !password_verify($password, $user->password) ){
            return redirect()->back()->with('error', 'Contraseña incorrecta');
        }

        $this->createSession($user);
        return true;
    }
    public function createSession(User $user){
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

        session()->set($this->sessionName, $user);
    }
    public function deleteSession(){
        session()->remove($this->sessionName);
    }
}