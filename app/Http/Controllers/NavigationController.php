<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NavigationController extends Controller
{
    // HOME
    public function index(){
        return view('index');
    }

    // LOGIN
    public function login(){
        return view('user.login');
    }

    // SOBRE
    public function about(){
        return view('about');
    }

    // Cadastrar
    public function register(){
        return view('user.register');
    }

    // EDITAR
    public function edit(){
        return view('user.edit');
    }

    // ERRO 404
    public function page_not_found(){
        return view('errors.404');
    }

    // CRIAR ADMIN
    public function create_admin(){
        return view('admin.create_admin');
    }

     // CRIAR TURMA
     public function create_team(){
        return view('admin.create_team');
    }
}
