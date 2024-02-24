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
@section('title', 'Take Notes - Página Não Encontrada')

{{-- Conteudo do site --}}
@section('content')
    <body class="body-main">
        @include('layouts/menu')
        <div class="container container-not-found">
            <div class="row row-not-found">
                <div class="col-md-6 col-sm-12 col-img-not-found">
                    <img src="{{asset('img/page_not_found.png')}}" class="img-not-found" srcset="">
                </div>
                <div class="col-md-6 col-sm-12 col-text-not-found">
                    <h1>404</h1>
                    <p>Turma Não Encontrada. Talvez ela tenha sido excluida</p>
                </div>
            </div>
        </div>
    </body>
@endsection

