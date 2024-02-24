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
    <body>
        <div class="background-home">
            @include('layouts/menu')
            <h1>Take Notes</h1>
            <p>Anote todas as suas informações importantes com o memso designer do Google Classroom</p>
        </div>
    <!-- @include("layouts/footer") -->
    </body>
    
@endsection

