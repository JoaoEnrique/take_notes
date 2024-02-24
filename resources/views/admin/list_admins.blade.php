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
@section('title', 'Take Notes - Listar Administradores')

{{-- Conteudo do site --}}
@section('content')
    <body>{{-- Menu --}}
        @include('layouts/menu')
        
        <div class="container container-list">
            {{-- MENSAGEM DE SUCESSO --}}
            @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: -30px!important;">
                    {{session()->get('success')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- MENSAGEM DE ERRO --}}
            @if(session()->has('danger'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: -30px!important;">
                    {{session()->get('danger')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <h3>Lista de Administradores</h3>
            <form id="search-form" style="margin-bottom: 20px">
                <input class="form-control" type="text" id="search-input" placeholder="Digite sua pesquisa">
            </form>


            {{-- TABELA DE ADMINS --}}
                <div class="div-table">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            {{-- <th scope="col">Código</th> --}}
                            <th scope="col" style="min-width: 70px; width: 70px;">Imagem</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Nome de Usuário</th>
                            <th scope="col">E-mail</th>
                            <th scope="col" style="min-width: 250px">Ação</th>
                        </tr>
                        <tbody id="search-results">
                            @foreach ($admins as $admin)
                                <tr>
                                    {{-- <th scope="row">{{$admin->id}}</th> ID ADMIN --}}
        
                                    {{--  Veririca se tem imagem --}}
                                    @php 
                                        $path = str_replace('../', "", $admin->img_account);

                                        if (file_exists($path)) {
                                            $img_account = asset($admin->img_account);
                                        } else {
                                            $img_account = asset('img/img_account/img_account.png');
                                        }

                                    @endphp
        
                                    {{-- IMAGEM CONTA --}}
                                    <td>
                                        <div class="img-account-menu-antes" style="background-image: url('{{$img_account}}')"></div>
                                    </td>
                                    
                                    {{-- NOME --}}
                                    <td>
                                        <a href="/{{$admin->username}}" style="color: #000;">
                                            {{$admin->name}}
                                        </a>
                                    </td> 

                                    {{-- NOME DE USUARIO--}}
                                    <td>
                                        <a href="/{{$admin->username}}" style="color: #000; text-decoration: none">
                                            {{$admin->name}}
                                        </a>
                                    </td>
                                    
                                    {{-- EMAIL --}}
                                    <td>{{$admin->email}}</td>

                                    {{-- BOTÃO EXCLUIR --}}
                                    <td>
                                        <!-- Botão para abrir o modal -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm-delete-admin-{{$admin->id}}">
                                            Excluir
                                        </button>
                                        <!-- Botão para abrir o modal -->
                                        <button style="color: #fff" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirm-user-admin-{{$admin->id}}">
                                            remover admin
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>

    {{-- Caso esteja logado, verifica se é admin --}}
    @if(auth()->check())
        {{-- veririca se é admin --}}
        @php
            $admin_controller = app(App\Http\Controllers\AdminController::class);
            $isAdmin = $admin_controller->isAdmin(auth()->user()->id);
        @endphp
    @endif

    {{-- CRIAR ADMIN --}}
    @if($isAdmin)
        <a class="btn-adicionar-livro" href="{{ route('admin.create') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"></path>
            </svg>
        </a>
    @endif

    </body>

    @foreach ($admins as $admin)
        <!-- Modal de Confirmação de Exclusão -->
        <div class="modal fade" id="confirm-delete-admin-{{$admin->id}}" tabindex="-1" aria-labelledby="confirm-delete-admin-{{$admin->id}}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirm-delete-admin-{{$admin->id}}">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Tem certeza de que deseja excluir este administrador(a)? Não é possível recuperar os dados.
                    </div>
                    <div class="modal-footer" style="flex-wrap: nowrap">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100%">
                            Cancelar
                        </button>
                        
                        <form id="form-delete-user-{{$admin->id}}" action="{{ route('user.delete', ['id' => $admin->id]) }}" method="post" class="d-none">
                            @csrf
                        </form>
                        
                        <a class="btn btn-danger" style="width: 100%" onclick="event.preventDefault(); console.log(document.getElementById('form-delete-user-{{$admin->id}}')); document.getElementById('form-delete-user-{{$admin->id}}').submit();">
                            Excluir
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal de Confirmação de tornar aluno -->
        <div class="modal fade" id="confirm-user-admin-{{$admin->id}}" tabindex="-1" aria-labelledby="confirm-user-admin-{{$admin->id}}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirm-user-admin-{{$admin->id}}">Confirmar Alteração</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Tem certeza de que deseja mudar {{$admin->name}} para usuário comum? Ele ainda terá uma conta, mas sem permissões adicionais.
                    </div>
                    <div class="modal-footer" style="flex-wrap: nowrap">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100%">
                            Cancelar
                        </button>
                        
                        <form id="form-user-user-{{$admin->id}}" action="{{ route('admin.switch_to_student', ['id' => $admin->id]) }}" method="post" class="d-none">
                            @csrf
                        </form>
                        
                        <a class="btn btn-primary" style="width: 100%" onclick="event.preventDefault(); console.log(document.getElementById('form-user-user-{{$admin->id}}')); document.getElementById('form-user-user-{{$admin->id}}').submit();">
                            Alterar
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <script src="{{asset('js/code.jquery.com_jquery-3.6.0.min.js')}}"></script>
        <script>
            $(document).ready(function () {
                $('#search-input').on('input', function () {
                    var query = $(this).val();
                    
                    $.ajax({
                        url: '{{ route('admin.search_admin') }}',
                        method: 'GET',
                        data: { query: query },
                        success: function (data) {
                            // Limpe os resultados anteriores
                            $('#search-results').empty();
        
                            // Verifique se a pesquisa não está vazia
                           
                                // Atualize a div de resultados com os dados retornados
                                $.each(data, function(index, admin) {
                                    if(admin){
                                        $('#search-results').append(
                                            
                                            '<tr>' +
                                                `<td> <div class="img-account-menu" style="background-image: url('${admin.img_account}')"></div></td>` +
                                                '<td><a href="/{{$admin->username}}" style="color: #000;">' + admin.name + '</a></td>' +
                                                '<td><a href="/{{$admin->username}}" style="color: #000; text-decoration:none">' + admin.username + '</a></td>' +
                                                '<td>' + admin.email + '</td>'+
                                                `
                                                <td>
                                                    <!-- Botão para abrir o modal -->
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm-delete-admin-{{$admin->id}}">
                                                        Excluir
                                                    </button>
                                                    <!-- Botão para abrir o modal -->
                                                    <button style="color: #fff" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirm-user-admin-{{$admin->id}}">
                                                        remover admin
                                                    </button>
                                                </td>
                                                ` +
                                            '</tr>'
                                        );
                                    }else{
                                        
                                    }
                                });
                          
                        }
                    });
                });
            });
        </script>
    @endforeach
@endsection

