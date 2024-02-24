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
@section('title', 'Smart Job - Listar Alunos')

{{-- Conteudo do site --}}
@section('content')
    <body>
        {{-- Menu --}}
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

            {{-- Caso tenha aluno cadastrado --}}
            @if(count($students) >=1)
                <h3>Lista de Alunos</h3>
                <form id="search-form" style="margin-bottom: 20px">
                    <input class="form-control" type="text" id="search-input" placeholder="Digite sua pesquisa">
                </form>

                {{-- TABELA DE student --}}
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
                            @foreach ($students as $student)
                                <tr>
                                    {{-- <th scope="row">{{$student->id}}</th> ID student --}}

                                    {{--  Veririca se tem imagem --}}
                                    @php 
                                        $path = str_replace('../', "", $student->img_account);

                                        if (file_exists($path)) {
                                            $img_account = asset($student->img_account);
                                        } else {
                                            $img_account = asset('img/img_account/img_account.png');
                                        }
                                    @endphp

                                    {{-- IMAGEM CONTA --}}
                                    <td>
                                        <div class="img-account-menu" style="background-image: url('{{asset($img_account)}}')"></div>
                                    </td>

                                    {{-- NOME --}}
                                    <td>
                                        <a href="/{{$student->username}}" style="color: #000;">
                                            {{$student->name}}
                                        </a>    
                                    </td>

                                    {{-- NOME DE USUARIO --}}
                                    <td>
                                        <a href="/{{$student->username}}" style="color: #000; text-decoration: none">
                                            {{$student->username}}
                                        </a>      
                                    </td>

                                    {{-- EMAIL --}}
                                    <td>{{$student->email}}</td>

                                    {{-- BOTÃO EXCLUIR --}}
                                    <td>
                                        <!-- Botão para abrir o modal -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm-delete-student-{{$student->id}}">
                                            Excluir
                                        </button>
                                        <!-- Botão para abrir o modal -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirm-admin-student-{{$student->id}}">
                                            Tornar Admin
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            {{-- Caso não tenha aluno cadastrado --}}
            @else
                <h3>Nenhum aluno cadastrado</h3>
            @endif
        </div>
    </body>

    {{-- Caso tenha aluno cadastrado --}}
    @if(count($students) >=1)
        @foreach ($students as $student)
            <!-- Modal de Confirmação de Exclusão -->
            <div class="modal fade" id="confirm-delete-student-{{$student->id}}" tabindex="-1" aria-labelledby="confirm-delete-student-{{$student->id}}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirm-delete-student-{{$student->id}}">Confirmar Exclusão</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Tem certeza de que deseja excluir este aluno(a)? Não é possível recuperar os dados.
                        </div>
                        <div class="modal-footer" style="flex-wrap: nowrap">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100%">
                                Cancelar
                            </button>

                            <form id="form-delete-user-{{$student->id}}" action="{{ route('user.delete', ['id' => $student->id]) }}" method="post" class="d-none">
                                @csrf
                            </form>
                            
                            <a class="btn btn-danger" style="width: 100%" onclick="event.preventDefault(); console.log(document.getElementById('form-delete-user-{{$student->id}}')); document.getElementById('form-delete-user-{{$student->id}}').submit();">
                                Excluir
                            </a>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal de Confirmação de tornar admin -->
            <div class="modal fade" id="confirm-admin-student-{{$student->id}}" tabindex="-1" aria-labelledby="confirm-admin-student-{{$student->id}}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirm-admin-student-{{$student->id}}">Confirmar Alteração</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Tem certeza de que deseja mudar {{$student->name}} para administrador? O usuário terá mais permissões dentro do site.
                        </div>
                        <div class="modal-footer" style="flex-wrap: nowrap">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100%">
                                Cancelar
                            </button>

                            <form id="form-admin-user-{{$student->id}}" action="{{ route('admin.switch_to_administrator', ['id' => $student->id]) }}" method="post" class="d-none">
                                @csrf
                            </form>
                            
                            <a class="btn btn-primary" style="width: 100%" onclick="event.preventDefault(); console.log(document.getElementById('form-admin-user-{{$student->id}}')); document.getElementById('form-admin-user-{{$student->id}}').submit();">
                                Tornar Admin
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
                    url: '{{ route('admin.search_student') }}',
                    method: 'GET',
                    data: { query: query },
                    success: function (data) {
                        // Limpe os resultados anteriores
                        $('#search-results').empty();
    
                        // Verifique se a pesquisa não está vazia
                       
                            // Atualize a div de resultados com os dados retornados
                            $.each(data, function(index, student) {
                                if(student && isset(student)){
                                    $('#search-results').append(
                                    '<tr>' +
                                    `<td> <div class="img-account-menu" style="background-image: url('${student.img_account}')"></div></td>` +
                                    '<td><a href="/{{$student->username}}" style="color: #000;">' + student.name + '</td>' +
                                    '<td><a href="/{{$student->username}}" style="color: #000; text-decoration: none">' + student.username + '</a></td>' +
                                    '<td>' + student.email + '</td>'+
                                    `
                                    <td>
                                        <!-- Botão para abrir o modal -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm-delete-student-{{$student->id}}">
                                            Excluir
                                        </button>
                                        <!-- Botão para abrir o modal -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirm-admin-student-{{$student->id}}">
                                            Tornar Admin
                                        </button>
                                    </td>
                            ` +
                                    '</tr>'
                                );
                                }
                               
                            });
                      
                    }
                });
            });
        });
    </script>
        @endforeach
    @endif
@endsection
