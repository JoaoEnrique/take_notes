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
@section('title', 'Take Notes - Criar Administrador')

{{-- Conteudo do site --}}
@section('content')
    <body class="body-register">
        @include('layouts/menu')
        <div class="container container-login">
            <div class="row row-login">
                <div class="col col-img-register" style="background: #5bb4ff">
                    <img src="{{asset('img/create_admin.png')}}" class="img-login" srcset="">
                </div>
                <div class="col">
                    <form class="row g-3 form-login" method="POST" action="{{ route('admin.create_team') }}">
                        @csrf
                        <h1>Criar Turma</h1>
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

                        {{-- Descrição --}}
                        <div class="mb-3">
                            <label for="text" class="form-label">Descrição</label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{old('description')}}" autocomplete="description">
                            
                            @error('description')
                                <span class="invalid-feedback" role="alert" style="text-align: left">
                                    {{$message}}
                                </span>
                            @enderror
                        </div>

                        {{-- Fechado --}}
                        <div class="mb-3">
                            <input class="form-check-input" type="checkbox" id="closed" name="closed">
                            <label class="form-check-label" for="closed">
                              Turma fechada
                            </label>
                            <div id="emailHelp" class="form-text">Se a turma for fechada, apenas administradores podem fazer publicações.</div>
                        </div>

                        <div class="mb-3">
                            Cor:
                        </div>
                        <div class="col-2" style="margin: 0 5px">
                            <input class="form-check-input d-none" type="radio" name="color" id="flexRadioDefault1" checked value="#5bb4ff">
                            <label class="label-color" for="flexRadioDefault1" style="background: #5bb4ff"></label>
                          </div>
                          <div class="col-2 mb-5" style="margin: 0 5px">
                            <input class="form-check-input d-none" type="radio" name="color" id="flexRadioDefault2" value="#009788">
                            <label class="label-color" for="flexRadioDefault2" style="background: #009788"></label>
                          </div>
                          <div class="col-2 mb-5" style="margin: 0 5px">
                            <input class="form-check-input d-none" type="radio" name="color" id="flexRadioDefault3" value="rgb(25, 103, 210)">
                            <label class="label-color" for="flexRadioDefault3" style="background: rgb(25, 103, 210)"></label>
                          </div>    
                          <div class="col-2 mb-5" style="margin: 0 5px">
                            <input class="form-check-input d-none" type="radio" name="color" id="flexRadioDefault4" value="rgb(95, 99, 104)">
                            <label class="label-color" for="flexRadioDefault4" style="background: rgb(95, 99, 104)"></label>
                          </div>    
                          <div class="col-2 mb-5" style="margin: 0 5px">
                            <input class="form-check-input d-none" type="radio" name="color" id="flexRadioDefault5" value="rgb(232, 113, 10)">
                            <label class="label-color" for="flexRadioDefault5" style="background: rgb(232, 113, 10)"></label>
                          </div>                     
                        <div class="mb-2">
                          <button class="btn btn-login" type="submit">Criar Turma</button>
                        </div>
                        <div class="" style="text-align: center">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>

    <script src="{{asset('js/code.jquery.com_jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
@endsection

