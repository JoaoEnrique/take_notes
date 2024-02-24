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
    <body class="body-register">
        @include('layouts/menu')
        <div class="container container-login">
            <div class="row row-login">
                <div class="col col-img-register" style="background: #5bb4ff">
                    <img src="{{asset('img/register.svg')}}" class="img-login" srcset="">
                </div>
                <div class="col">
                    <form class="row g-3 form-login" method="POST" action="{{ route('register') }}">
                        @csrf
                        <h1>Cadastre-se</h1>
                        {{-- NOME --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name')}}" autocomplete="name" autofocus>
                            
                            @error('name')
                                <span class="invalid-feedback" role="alert" style="text-align: left">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>

                        {{-- EMAIL --}}
                        <div class="col-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email')}}" autocomplete="email">
                            
                            @error('email')
                                <span class="invalid-feedback" role="alert" style="text-align: left">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>

                        {{-- NOME DE USUÁRIO --}}
                        <div class="col-6 mb-3">
                            <label for="username" class="form-label">Nome de usuário</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{old('username')}}" autocomplete="none">
                            
                            @error('username')
                                <span class="invalid-feedback" role="alert" style="text-align: left">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>

                        {{-- SENHA --}}
                        <div class="mb-3">
                          <label for="password" class="form-label">Senha</label>
                            <div class="col" style="position: relative">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password_confirmation') }}" autocomplete="password">
                                <img class="view-password" id="view-password" src="{{asset('img/eye.svg')}}" onclick="showPassword()" srcset="">
                            </div>

                            @error('password')
                                <span class="invalid-feedback" role="alert" style="text-align: left; display: block!important">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- SENHA --}}
                        <div class="mb-5">
                          <label for="password_confirmation" class="form-label">Senha</label>
                            <div class="col" style="position: relative">
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" autocomplete="new-password">
                                <img class="view-password" id="view-password-confirm" src="{{asset('img/eye.svg')}}" onclick="showPasswordConfirm()" srcset="">
                            </div>

                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert" style="text-align: left; display: block!important">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        
                        <div class="mb-2">
                          <button class="btn btn-login" type="submit">Cadastrar</button>
                        </div>
                        <div class="" style="text-align: center">
                            <a href="{{route('login')}}">Já tem conta? Faça Login</a>
                        </div>
                    </form>
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

