{{-- 
    "PRA QUE SERVE
    TANTO CÓDIGO
    SE A VIDA
    NÃO É PROGRAMADA
    E AS MELHORES COISAS
    NÃO TEM LÓGICA". 
    Algúem (algum ano)
--}}

@extends('layouts.main')
@section('title', 'Take Notes')

{{-- Conteudo do site --}}
@section('content')
    <body class="body-login">
        @include('layouts/menu')
        <div class="container container-login">
            <div class="row row-login">
                <div class="col" style="flex-wrap: wrap; position: relative;">
                    
                    {{-- MENSAGENS --}}
                    <div class="row row-notification-login form-login" style="width: 100%">
                        {{-- MENSAGEM SUCCESSO --}}
                        @if(session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade alert-login show" role="alert">
                                {{session()->get('success')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        
                        {{-- MENSAGEM ERRO --}}
                        @if(session()->has('danger'))
                            <div class="alert alert-danger alert-dismissible fade alert-login show" role="alert">
                                {{session()->get('danger')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                    </div>
                    
                    {{-- FORMULARIO --}}
                    <form class="row g-3 form-login" method="POST" action="{{ route('login') }}">
                        @csrf
                        <h1>Login</h1>
                        {{-- EMAIL --}}
                        <div class="mb-4 form-floating">
                          <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email')}}" autocomplete="email" placeholder="name@example.com" autofocus>
                          <label for="email">Email</label>                          
                            @error('email')
                                <span class="invalid-feedback" role="alert" style="text-align: left">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>

                        {{-- SENHA --}}
                        <div class="mb-1">
                            <div class="col form-floating" style="position: relative;">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{old('password')}}" placeholder="">
                                <img class="view-password" id="view-password" src="{{asset('img/eye.svg')}}" onclick="showPassword()" srcset="">
                                <label for="password" class="form-label">Senha</label>
                            </div>

                            @error('password')
                                <span class="invalid-feedback" role="alert" style="text-align: left; display: block!important">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- MANTER LOGADO --}}
                        <div class="mb-5">
                            <input class="form-check-input" type="checkbox" value="" id="remember">
                            <label class="form-check-label" for="remember">
                              Manter logado
                            </label>
                          </div>
                        <div class="mb-2">
                          <button class="btn btn-login" type="submit">Entrar</button>
                        </div>
                        <div class="" style="text-align: center">
                            <a href="{{route('register')}}">Não tem conta? Cadastre-se</a>
                        </div>
                    </form>
                </div>
                <div class="col col-img-login" style="background: #5bb4ff">
                    <img src="{{asset('img/login.svg')}}" class="img-login" srcset="">
                </div>
            </div>
        </div>
        
        {{-- BOTÃO WHATSAPP --}}
        <a target="_BLANK" class="btn-adicionar-livro"  href="https://api.whatsapp.com/send?phone=+5528999571689&text=Take Notes" style="background: #40C351;">
            <img src="../img/whatsapp_green.png" height="40px" srcset="">
        </a>
    </body>

    <script src="{{asset('js/code.jquery.com_jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
@endsection

