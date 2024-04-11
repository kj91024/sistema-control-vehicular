<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function dashboard(): string
    {
        return view('welcome_message');
    }
    public function ingreso(string $placa): string
    {
        return view('welcome_message');
    }
    public function salida(string $placa): string
    {

        return view('welcome_message');
    }
}
