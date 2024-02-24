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
        <div class="container container-account" style="padding-bottom: 100px; position: relative">
            {{-- MENSAGEM DE SUCESSO --}}
            @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 30px!important;">
                    {{session()->get('success')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- MENSAGEM DE ERRO --}}
            @if(session()->has('danger'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 30px!important;">
                    {{session()->get('danger')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row" style="justify-content: center;">
                <div class="col-md-8 col-sm-8 col-name-usser">
                    <h2>{{$user->name}}</h2>
                    <p>{{"@$user->username"}}</p>
                    {{-- <p class="seguidores">3 
                        publicações &nbsp;&nbsp; - &nbsp;&nbsp;  
                        <span id="numero-seguidor">1</span> seguidores &nbsp;&nbsp; - &nbsp;&nbsp; 
                        1 seguindo
                    </p>  --}}

                    @if(auth()->check() && $user->id == auth()->user()->id)
                        <a href="{{route('account.edit')}}" class="btn btn-yellow" style="width: 100%;">
                            Editar
                        </a>
                    @else
                    
                        @php
                            $admin_controller = app(App\Http\Controllers\AdminController::class);
                            $isAdmin = $admin_controller->isAdmin(auth()->user()->id);
                        @endphp


                        @if($isAdmin)

                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm-delete-user" style="width: 100%;">
                                Excluir
                            </button>
                        @endif
                    @endif
                </div>

                <div class="col-md-2 col-sm-2 col-img-cosnta">
                    <div class="img-conta-perfil" style="background-image: url('{{$user->img_account}}')"></div>
                </div>
            </div>
    
            <div class="row">
                <div class="hr"></div>
            </div>
    
            
            {{-- <div class="row row-filtro-account">
                
                <div class="col" style="border-bottom: 2px solid #000">
                    <a href="/joao">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon-fillter bi bi-image-fill" viewBox="0 0 16 16">
                                <path d="M.002 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-12a2 2 0 0 1-2-2V3zm1 9v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V9.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12zm5-6.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0z"></path>
                            </svg>
                                        </a>
                </div>
    
                
                <div class="col">
                    <a href="/joao?fillter=text">
                                                <svg style="opacity: 0.5;" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon-fillter bi bi-chat-square-text" viewBox="0 0 16 16">
                                <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"></path>
                                <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                            </svg>
                                        </a>
                </div>
    
                
                <div class="col">
                    <a href="/joao?fillter=all">
                                                <svg style="opacity: 0.5;" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon-fillter bi bi-postcard-heart" viewBox="0 0 16 16">
                                <path d="M8 4.5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7Zm3.5.878c1.482-1.42 4.795 1.392 0 4.622-4.795-3.23-1.482-6.043 0-4.622ZM2.5 5a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3Zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3Zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3Z"></path>
                                <path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H2Z"></path>
                            </svg>
                                        </a>
                </div>
            </div>
    
            <div class="row">
                <div class="hr"></div>
            </div>
    
            <div class="row" style="justify-content: start"> --}}
                
                            
                                                
                         
{{--                         
                                                                            <div class="col-lg-4 col-6" style="margin-top: 10px">
                                    
    
                                    <div type="button" data-bs-toggle="modal" data-bs-target="#modal-img-24" class="card card-post-account" style="background-image: url('public/img/img_post/31.png'); margin: 0px 0;"></div>
            
                                    <!-- MODAL DE IMAGENS -->
                                    <div class="modal fade" id="modal-img-24" tabindex="-1" aria-labelledby="modal-img-24" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="overflow: auto; max-height: 70vh; padding: 0 !important">
                                                <img src="public/img/img_post/31.png" class="img-post" srcset="" style="width: 100%;height: 100%;">
                                            </div>
                                            <div class="none-mobile modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                                    
                         
                        
                                                        
                         
                        
                                                                            <div class="col-lg-4 col-6" style="margin-top: 10px">
                                    
    
                                    <div type="button" data-bs-toggle="modal" data-bs-target="#modal-img-21" class="card card-post-account" style="background-image: url('../img/img_post/27.png'); margin: 0px 0;"></div>
            
                                    <!-- MODAL DE IMAGENS -->
                                    <div class="modal fade" id="modal-img-21" tabindex="-1" aria-labelledby="modal-img-21" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="overflow: auto; max-height: 70vh; padding: 0 !important">
                                                <img src="../img/img_post/27.png" class="img-post" srcset="" style="width: 100%;height: 100%;">
                                            </div>
                                            <div class="none-mobile modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                                    
                
                        </div> --}}
        </div>

         <!-- Modal de Confirmação de Exclusão -->
         <div class="modal fade" id="confirm-delete-user" tabindex="-1" aria-labelledby="confirm-delete-user" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirm-delete-student">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Tem certeza de que deseja excluir este usuário(a)? Não é possível recuperar os dados.
                    </div>
                    <div class="modal-footer" style="flex-wrap: nowrap">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100%">
                            Cancelar
                        </button>

                        <form id="form-delete-user" action="{{ route('user.delete', ['id' => $user->id]) }}" method="post" class="d-none">
                            @csrf
                        </form>
                        
                        <a class="btn btn-danger" style="width: 100%" onclick="event.preventDefault(); console.log(document.getElementById('form-delete-user')); document.getElementById('form-delete-user').submit();">
                            Excluir
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </body>
@endsection

