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
    <body class="body-main">
        @include('layouts/menu')
        <div class="container container-home">
            <div class="row row-home">
                <div class="col col-text-home">
                    <h1>SOBRE</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam vero repellendus quae molestiae ratione sed modi earum, saepe</p>
                </div>
                <div class="col col-img-search-people">
                    <img src="{{asset('img/search_people.png')}}" class="img-search-people" srcset="">
                </div>
            </div>
        </div>
    </body>
@endsection

