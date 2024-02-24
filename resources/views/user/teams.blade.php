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

        {{-- SABER SE É ADMIN --}}
        @if(auth()->check())
            {{-- veririca se é admin --}}
            @php
                $admin_controller = app(App\Http\Controllers\AdminController::class);
                $isAdmin = $admin_controller->isAdmin(auth()->user()->id);
            @endphp
        @endif

        
        @include('layouts/menu')
        <div class="container container-teams">
            <div class="row-card-teams">
                
                {{-- MENSAGEM DE SUCESSO --}}
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" style="width: 100%" role="alert">
                        {{session()->get('success')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- MENSAGEM DE ERRO --}}
                @if(session()->has('danger'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{session()->get('danger')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- MENSAGEM DE WARNING --}}
                @if(session()->has('danger'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{session()->get('warning')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                {{-- Form para entrar na  turma se não for admin --}}
                @if(!$isAdmin)
                    <div class="form-open-team" style="width: 100%">
                        <form action="{{route('team.enter')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-7">
                                    <input class="form-control @error('team_code') is-invalid @enderror" type="text" placeholder="Código da turma" name="team_code" id="team_code" value="{{old('team_code')}}">                       
                                    
                                    @error('team_code')
                                        <span class="invalid-feedback" role="alert" style="text-align: left; display: block!important;">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <button class="btn btn-open-team" type="submit">Entrar na turma</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif

                @foreach($teams as $team)
                    <!-- <a href="/team/{{$team->team_code}}" style="text-decoration: none;color: #fff"> -->
                        <div onclick="window.location.href = '/team/{{$team->team_code}}';" class="card card-teams" style="background: {{  $team->color  }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title">{{  $team->name  }}</h5>
                                        <p class="card-text">{{  $team->description  }}</p>
                                        <p class="count-student">
                                            @php
                                                $count_users_teams = $admin_controller->count_users_teams($team->id_teams);

                                                if($count_users_teams<= 0){
                                                    echo "$count_users_teams usuário";
                                                }else{
                                                    echo "$count_users_teams usuário";
                                                }
                                            @endphp
                                            
                                        </p>
                                    </div>
                                        <div class="col-2" style="position: absolute; top: 0; right: 0;z-index: 999!important;">
                                            <div class="config-card-teams">
                                                <ul class="navbar-nav">
                                                    <li class="nav-item dropdown" style="flex-wrap: wrap;">
                                                        {{-- SVG de CONFIG --}}
                                                        <a class="nav-link dropdown-toggle dropdown-config-teams" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 100%; display: flex; align-items: center;">
                                                            <svg focusable="false" width="24" height="24" viewBox="0 0 24 24" class=" NMm5M">
                                                                <path fill="#fff" d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
                                                            </svg>
                                                        </a>
                                                        
                                                        {{-- Codigo da turma para copiar --}}
                                                        <textarea class="d-none team_code{{$team->id_teams}}">{{$team->team_code}}</textarea>

                                                        <ul class="dropdown-menu dropdown-100">
                                                            @if($isAdmin)
                                                                <li>
                                                                    <!-- Botão para abrir o modal -->
                                                                    <a  type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#cod-team-{{$team->id_teams}}">
                                                                        Copiar código
                                                                    </a>
                                                                </li>
                                                                <li><a class="dropdown-item" href="{{ url('/edit-team/' . $team->id_teams) }}">Editar</a></li>
                                                                {{-- PAGAR tURMA--}}
                                                                <li>
                                                                    <!-- Botão para abrir o modal -->
                                                                    <a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#confirm-delete-team-{{$team->id_teams}}">
                                                                        Apagar
                                                                    </a>
                                                                </li>
                                                            @endif
                                                            <li>
                                                                <!-- Botão para abrir o modal -->
                                                                <a  type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-users-team-{{$team->id_teams}}">
                                                                    Usuários
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                       
                                </div>
                            </div>
                        </div>
                    <!-- </a> -->
                @endforeach

                {{-- CRIAR TURMA --}}
                @if($isAdmin)
                    <a class="btn-adicionar-livro" href="{{ route('admin.create_team') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"></path>
                        </svg>
                    </a>
                @endif
            </div>

            {{-- Se for admin e não tiver turma criada --}}
            @if($isAdmin && count($teams) <=0)
                <div class="form-open-team">
                    <h3>Nenhuma turma criada <a href="{{ route('admin.create_team') }}">Crie uma aqui</a></h3> 
                </div>
            @endif

            {{-- Se não for admin e não tiver turma criada --}}
            @if(!$isAdmin && count($teams) <=0)
                <div class="form-open-team">
                    <h3>Você ainda não entrou em uma turma</h3> 
                </div>
            @endif

            @if(count($teams) >0)
                <p style="text-align: center; margin-top: 50px">Fim das turmas</p>
            @endif

    @if(count($teams) >=1)
        @foreach ($teams as $team)
            <!-- Modal de Confirmação de Exclusão -->
            <div class="modal fade" id="confirm-delete-team-{{$team->id_teams}}" tabindex="-1" aria-labelledby="confirm-delete-team-{{$team->id_teams}}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirm-delete-team-{{$team->id_teams}}">Confirmar Exclusão</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Tem certeza de que deseja excluir essa turma? Não é possível recuperar os dados.
                        </div>
                        <div class="modal-footer" style="flex-wrap: nowrap">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100%">
                                Cancelar
                            </button>

                            <form id="form-delete-team-{{$team->id_teams}}" action="{{ route('team.delete', ['id_team' => $team->id_teams]) }}" method="post" class="d-none">
                                @csrf
                            </form>
                            
                            <a class="btn btn-danger" style="width: 100%" onclick="event.preventDefault(); console.log(document.getElementById('form-delete-team-{{$team->id}}')); document.getElementById('form-delete-team-{{$team->id_teams}}').submit();">
                                Excluir
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal código da turma --}}
            <div class="modal fade" id="cod-team-{{$team->id_teams}}" tabindex="-1" aria-labelledby="cod-team-{{$team->id_teams}}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cod-team-{{$team->id_teams}}">Copiar código</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            O código da turma {{$team->name}} é: <strong>{{$team->team_code}}</strong>. Copie o código e compartilhe para o usuário entrar na turma.
                        </div>
                        <div class="modal-footer" style="flex-wrap: nowrap">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100%">
                                Fechar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal ver usuarios da turma --}}
            <div class="modal fade" id="view-users-team-{{$team->id_teams}}" tabindex="-1" aria-labelledby="view-users-team-{{$team->id_teams}}" aria-hidden="true">
                <div class="modal-dialog" style="margin: 0 auto">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="view-users-team-{{$team->id_teams}}">Usuários da turma</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="border:0!important">
                            @php
                                $users = $admin_controller->view_users_teams($team->id_teams);
                            @endphp

                            @foreach ($users as $user)
                                @php 
                                    $path = str_replace('../', "", $user->img_account);
            
                                    if (file_exists($path)) {
                                        $img_account = asset($user->img_account);
                                    } else {
                                        $img_account = asset('img/img_account/img_account.png');
                                    }
                                @endphp
                                {{--  --}}
                                <div class="row" style="border-bottom: 1px solid #d3d3d3; padding-bottom: 15px; padding-top: 15px;">
                                    <div class="" style="width: 65px">
                                        {{-- <img src="{{asset(auth()->user()->img_account)}}" height="50px" srcset=""> --}}
                                        <div class="img-account-user-team" style="background-image: url('{{asset($img_account)}}')"></div>
                                    </div>
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <p style="margin: 0; font-size: 18px"><a href="/{{$user->username}}" style="color: #000; text-decoration: none">{{$user->name}}</a></p>
                                                <p style="font-size: 15px"><a href="/{{$user->username}}" style="color: #000; text-decoration: none">{{"@" . $user->username}}</a></p>
                                            </div>
                                        </div>
                                        <div class="col" style="margin-bottom: 10px;">
                                            <!-- Botão para abrir o modal -->
                                            <a style="width: 100%"  type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#remove-user-{{$user->id}}-{{$team->id_teams}}">
                                                Remover da turma
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @if(count($users) <=0 )
                                <h3>Nenhum usuário entrou na turma</h3>
                            @endif
                        </div>
                        <div class="modal-footer" style="flex-wrap: nowrap; border:0!important">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100%">
                                Fechar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            @php
                $users = $admin_controller->view_users_teams($team->id_teams);
            @endphp

            @foreach ($users as $user)
                <!-- Modal de remover usuario -->
                <div class="modal fade" id="remove-user-{{$user->id}}-{{$team->id_teams}}" tabindex="-1" aria-labelledby="remove-user-{{$user->id}}-{{$team->id_teams}}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="remove-user-{{$user->id}}-{{$team->id_teams}}">Remover usuário</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Tem certeza de que deseja remover esse usuário da turma?
                            </div>
                            <div class="modal-footer" style="flex-wrap: nowrap">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100%">
                                    Cancelar
                                </button>
                                <!-- Botão para abrir o modal -->
                                <form id="form-remove-user-{{$user->id}}" action="{{ route('team.remove_user', ['id' => $user->id]) }}" method="post" class="d-none">
                                    <input type="text" name="id_user" id="id_user" value="{{$user->id}}">
                                    <input type="text" name="id_team" id="id_team" value="{{$team->id_teams}}">
                                    @csrf
                                </form>
                                
                                <a class="btn btn-danger" style="width: 100%" onclick="event.preventDefault(); console.log(document.getElementById('form-remove-user-{{$user->id}}')); document.getElementById('form-remove-user-{{$user->id}}').submit();">
                                    Remover
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        @endforeach
    @endif
@endsection

