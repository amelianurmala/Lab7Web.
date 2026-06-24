<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title'   => 'Halaman Home',
            'content' => 'Selamat datang di website saya'
        ];
        return view('home', $data);
    }
}