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
                $user_controller = app(App\Http\Controllers\UserController::class);
                $isAdmin = $admin_controller->isAdmin(auth()->user()->id);
            @endphp
        @endif

        
        @include('layouts/menu')
        
        <div class="row-card-teams row-card-team-choose">
            <div class="card card-teams card-team-full" style="background: {{  $team->color  }}; border-radius: 0;">
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
        </div>

        <div class="container container-team">
                {{-- MENSAGEM DE SUCESSO --}}
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
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


            {{-- POSTAR MENSAGEM CASO SEJA ADMIN OU A TURMA ESTEJA ABERTA --}}
            @if($team->closed && $isAdmin || !$team->closed)
            {{-- o  enctype="multipart/form-data" serve para salvar arquivos --}}
                <form method="post" action="{{route('team.message')}}" class="form-public-team" enctype="multipart/form-data">
                    @csrf

                    {{-- ID TURMA --}}
                    <input type="text" class="d-none" name="id_team" id="id_team" value="{{$team->id_teams}}" placeholder="Mensagem">

                    {{-- MENSAGE --}}
                    <textarea style="min-height: 100px" value="{{old('message')}}" class="form-control text-form-public-team @error('message') is-invalid @enderror" name="message" id="message" rows="3" placeholder="Mensagem"></textarea>

                    @if($errors->any())
                        <div class="alert alert-danger @if(count($errors->all()) <=1 && $errors->all()[0] == 'O campo mensagem é obrigatório.') d-none @endif" style="margin-top: 10px">
                            <ul>
                                @foreach($errors->all() as $error)
                                    @if($error != 'O campo mensagem é obrigatório.')
                                        <li>{{ $error }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div id="preview-img" class="div-img-preview-message-team-horizontal div-img-preview-message-team" style="display: none">
                        <img src=""  class="img-preview-message-team" srcset="">
                        <img src=""  class="img-preview-message-team-dois" srcset="">
                    </div>

                    <div id="preview-video" class="div-img-preview-message-team-quadrado div-img-preview-message-team" style="display: none">
                        {{-- <video class="video-preview-message-team" src="" controls></video> --}}
                        <video  controls="controls" class="video-preview-message-team img-account-comment" srcset="" style="width: 100%;height: 100%; margin: 0 5px;">
                            <source src="" type="video/mp4">
                        </video>
                    </div>

                    <div class="pdf-preview" id="pdf-preview">
                        <div class="pdf-icon">
                            <img src="{{asset('img/add-file.png')}}" alt="Ícone PDF">
                        </div>
                        <div class="pdf-details">
                            <p class="pdf-name" id="pdf-name">Nome do Arquivo.pdf</p>
                            <p class="pdf-size" id="pdf-size">Tamanho: 2.5 MB</p>
                        </div>
                    </div>

                    <input class="d-none" type="file" name="img" id="img" accept="image/*">
                    <input class="d-none" type="file" name="video" id="video" accept="video/mp4, video/webm">
                    <input class="d-none" type="file" name="file" id="file" accept=".pdf,.doc,.txt, .docx">

                    @error('message')
                        <span class="invalid-feedback" role="alert" style="text-align: left; display: block!important">
                            {{ $message }}
                        </span>
                    @enderror

                    <div class="row">
                        <div class="col" style="margin-top: 20px">
                            <div class="row row-file-team" style="flex-wrap: nowrap">
                                <div class="col-4 col-md-2 col-xl-2">
                                    <label for="img">
                                        <div class="img">
                                            <img src="{{asset('img/add-image.png')}}" class="img-add-file" srcset="">
                                        </div>
                                    </label>
                                </div>
                                <div class="col-4  col-md-2 col-xl-2">
                                    <label for="video">
                                        <div class="video">
                                            <img src="{{asset('img/add-video.png')}}" class="img-add-file" srcset="">
                                        </div>
                                    </label>
                                </div>
                                <div class="col-4 col-md-2 col-xl-2">
                                    <label for="file">
                                        <div class="file">
                                            <img src="{{asset('img/add-file.png')}}" class="img-add-file" srcset="">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                
                        <div class="col" style="display: flex; justify-content:end; margin-top: 20px" >
                            <button class="btn btn-send-mensage-team btn-yellow" type="submit">Enviar</button>
                        </div>
                    </div>
                </form>
            @else
                <div class="div-public-team" style="margin-top: 20px; padding: 20px">
                    <p>Somente administradoes podem publicar nesta turma</p>
                </div>
            @endif

                @foreach($messages as $message)
                    <div class="div-public-team" style="margin-top: 20px; padding: 20px; position:relative;">
                        <div class="row">
                            <div class="col-2 col-md-1">
                                <div class="img-public-team" style="background-image: url('{{asset($message->img_account)}}')"></div>
                            </div>
                            <div class="col">
                                @php
                                    $dataPostagem = strtotime($message->created_at);
                                    $dataAtual = time();
                                    $diferencaSegundos = $dataAtual - $dataPostagem;

                                    if ($diferencaSegundos < 60) {
                                        $tempo =  'há menos de um minuto';
                                    } elseif ($diferencaSegundos < 3600) {
                                        $minutos = floor($diferencaSegundos / 60);
                                        $tempo =  'há ' . $minutos . ' minuto(s)';
                                    } elseif ($diferencaSegundos < 86400) {
                                        $horas = floor($diferencaSegundos / 3600);
                                        $tempo =  'há ' . $horas . ' hora(s)';
                                    } elseif ($diferencaSegundos < 2592000) {
                                        $dias = floor($diferencaSegundos / 86400);
                                        if($dias == 1){
                                            $tempo =  'ontem';
                                        }else{
                                            $tempo =  'há ' . $dias . ' dia(s)';
                                        }
                                    } else {
                                        $tempo =  date('d/m/Y', $dataPostagem);
                                    }
                                @endphp

                                <h6> {{-- NOME --}}
                                    <a style="color: #000; text-decoration: none" href="{{route('account', ['username' => $message->username])}}" href="">
                                        {{  $message->name  }} - {{ $tempo }}
                                    </a>
                                </h6>
                                {{-- NOME DE USUARIO --}}
                                <p class="username-public-team">
                                    <a style="color: #000; text-decoration: none" href="{{route('account', ['username' => $message->username])}}" href="">
                                        {{ "@$message->username"   }}
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                @php
                                    $padrao_link = '/(https?:\/\/[^\s]+)/';
                                    $texto_formatado = preg_replace_callback($padrao_link, function ($match) {
                                        $url = $match[0];
                                        return "<a href='$url' target='_blank' style='word-wrap: break-word;'>$url</a>";
                                    }, $message->text);
                                    @endphp
                                <p class="">{!! nl2br($texto_formatado) !!}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                @php
                                    $files = $user_controller->getFilesByIdMessage($message->id_message_team);
                                @endphp
                                @foreach($files as $file)

                                    @if(file_exists($file->path_file) && $file->type_file == 1)
                                    
                                        @php
                                            // Caminho para a imagem que você deseja verificar
                                            $imagem = $file->path_file;

                                            // Obtém as dimensões da imagem
                                            list($largura, $altura) = getimagesize($imagem);

                                            // Verifica a orientação
                                            if ($largura > $altura) {
                                                $img_orientacao = 'div-img-preview-message-team-horizontal';
                                            } elseif ($largura < $altura) {
                                                $img_orientacao = 'div-img-preview-message-team-vertical';
                                            } else {
                                                $img_orientacao = 'div-img-preview-message-team-quadrado';
                                            }
                                        @endphp
                                        <div id="preview-img" class="{{$img_orientacao}} div-img-preview-message-team" style="display: flex">
                                            <img src="{{asset($file->path_file)}}"  class="img-preview-message-team" srcset="">
                                            <img src="{{asset($file->path_file)}}"  class="img-preview-message-team-dois" srcset="">
                                        </div>

                                    @elseif(file_exists($file->path_file) && $file->type_file == 2)
                                        <div id="preview-video" class="div-img-preview-message-team-video div-img-preview-message-team" style="display: flex">
                                      
                                             <video  controls="controls" class="video-preview-message-team img-account-comment" srcset="" style="width: 100%;height: 100%; margin: 0 5px;">
                                                <source src="{{asset($file->path_file)}}" type="video/mp4">
                                            </video>
                                        </div>

                                    @elseif(file_exists($file->path_file) && $file->type_file == 3)
                                        <div class="pdf-preview" id="pdf-preview" style="display: flex; position:relative;">
                                            <div class="col-2" style="position: absolute; top: 0; right: 0;">
                                                <div class="config-card-teams">
                                                    <ul class="navbar-nav">
                                                        <li class="nav-item dropdown" style="flex-wrap: wrap;">
                                                            {{-- SVG de CONFIG --}}
                                                            <a class="nav-link dropdown-toggle dropdown-config-teams" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 100%; display: flex; align-items: center;">
                                                                <svg focusable="false" width="24" height="24" viewBox="0 0 24 24" class=" NMm5M">
                                                                    <path fill="#686669" d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
                                                                </svg>
                                                            </a>
                
                                                            <ul class="dropdown-menu dropdown-100">
                                                                <li>
                                                                    <!-- Botão para abrir o modal -->
                                                                    <a download type="button" class="dropdown-item" href="{{asset($file->path_file)}}">
                                                                        Baixar
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>


                                            <div class="pdf-icon">
                                                <img src="{{asset('img/add-file.png')}}" alt="Ícone PDF">
                                            </div>
                                            <div class="pdf-details">
                                                <p class="pdf-name" id="pdf-name">{{ $file->file_name }}</p>
                                            </div>
                                        </div>

                                    @endif

                                @endforeach
                            </div>
                        </div>

                        {{-- EDITAR MENSAGEM SE FOR DO USUARIO LOGADO OU FOR ADMIN --}}
                        @if($isAdmin || auth()->user()->id == $message->id)
                            <div class="col-2" style="position: absolute; top: 0; right: 0;">
                                <div class="config-card-teams">
                                    <ul class="navbar-nav">
                                        <li class="nav-item dropdown" style="flex-wrap: wrap;">
                                            {{-- SVG de CONFIG --}}
                                            <a class="nav-link dropdown-toggle dropdown-config-teams" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 100%; display: flex; align-items: center;">
                                                <svg focusable="false" width="24" height="24" viewBox="0 0 24 24" class=" NMm5M">
                                                    <path fill="#686669" d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
                                                </svg>
                                            </a>

                                            <ul class="dropdown-menu dropdown-100">
                                                <li>
                                                    <!-- Botão para abrir o modal -->
                                                    <a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#confirm-edit-message-{{$message->id_message_team}}">
                                                        Editar
                                                    </a>
                                                </li>
                                                {{-- PAGAR tURMA--}}
                                                <li>
                                                    <!-- Botão para abrir o modal -->
                                                    <a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#confirm-delete-message-{{$message->id_message_team}}">
                                                        Apagar
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endif
                </div>
            @endforeach
            
            @if(count($messages) >= 2)
                <p style="text-align: center; margin-top: 50px">Fim das mensagens</p>
            @endif
        </div>
    </body>

    {{-- APAGAR E EDITAR MENSAGEM --}}
    @if(count($messages) >=1)
        @foreach ($messages as $message)
            <!-- APAGAR -->
            <div class="modal fade" id="confirm-delete-message-{{$message->id_message_team}}" tabindex="-1" aria-labelledby="confirm-delete-message-{{$message->id_message_team}}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirm-delete-message-{{$message->id_message_team}}">Confirmar Exclusão</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Tem certeza de que deseja excluir essa mensagem? Não é possível recuperar.
                        </div>
                        <div class="modal-footer" style="flex-wrap: nowrap">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100%">
                                Cancelar
                            </button>

                            <form id="form-delete-message-{{$message->id_message_team}}" action="{{route('message.delete', ['id_message_team' => $message->id_message_team])}}" method="post" class="d-none">
                                @csrf
                            </form>
                            
                            <a class="btn btn-danger" style="width: 100%" onclick="event.preventDefault(); document.getElementById('form-delete-message-{{$message->id_message_team}}').submit();">
                                Excluir
                            </a>
                        </div>
                        {{-- {{ route('message.delete', ['id_team' => $message->id_teams]) }} --}}
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


            <!-- EDITAR -->
            <div class="modal fade" id="confirm-edit-message-{{$message->id_message_team}}" tabindex="-1" aria-labelledby="confirm-edit-message-{{$message->id_message_team}}" aria-hidden="true">
                <div class="modal-dialog modal-edit-message modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirm-edit-message-{{$message->id_message_team}}">Editar Mensagem</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            
                            {{-- EDITAR --}}
                            <form method="post" action="{{route('message.update')}}" class="form-edit-public-team">
                                @csrf
                                {{-- ID TURMA --}}
                                <input type="text" class="d-none" name="id_message_team" id="id_message_team" value="{{$message->id_message_team}}" placeholder="Mensagem">
            
                                {{-- MENSAGE --}}
                                <textarea style="min-height: 500px" class="form-control text-form-public-team @error('message') is-invalid @enderror" name="message" id="message" rows="3" placeholder="Mensagem">{{$message->text}}</textarea>
            
                                @error('message')
                                    <span class="invalid-feedback" role="alert" style="text-align: left; display: block!important">
                                        {{ $message }}
                                    </span>
                                @enderror
                                
                                <div class="row">
                                    <div class="col" style="margin-top: 20px" >
                                        <button style="width: 100%;" class="btn btn-yellow" type="submit">Atualizar</button>
                                        
                                    </div>
                                    <div class="col" style="margin-top: 20px" >
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100%">
                                            Cancelar
                                        </button>
            
                                        <form id="form-edit-message-{{$message->id_message_team}}" action="{{route('message.delete', ['id_message_team' => $message->id_message_team])}}" method="post" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </form>

                        </div>
                        {{-- {{ route('message.delete', ['id_team' => $message->id_teams]) }} --}}
                    </div>
                </div>
            </div>
        @endforeach
    @endif


    {{-- APAGAR TURMA --}}
    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal fade" id="confirm-delete-team-{{$team->id_teams}}" tabindex="-1" aria-labelledby="confirm-delete-team-{{$team->id_teams}}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirm-delete-team-{{$team->id_teams}}">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza de que deseja excluir essa Turma? Não é possível recuperar os dados.
                </div>
                <div class="modal-footer" style="flex-wrap: nowrap">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100%">
                        Cancelar
                    </button>

                    <form id="form-delete-team-{{$team->id_teams}}" action="{{ route('team.delete', ['id_team' => $team->id_teams]) }}" method="post" class="d-none">
                        @csrf
                    </form>
                    
                    <a class="btn btn-danger" style="width: 100%" onclick="event.preventDefault(); console.log(document.getElementById('form-delete-team-{{$team->id_teams}}')); document.getElementById('form-delete-team-{{$team->id_teams}}').submit();">
                        Excluir
                    </a>
                </div>
                {{-- {{ route('message.delete', ['id_team' => $message->id_teams]) }} --}}
            </div>
        </div>
    </div>

    <script>
        // Obtém o elemento textarea
        var textarea = document.getElementById('message');
      
        // Define a altura inicial com base no conteúdo
        textarea.style.height = (textarea.scrollHeight) + 'px';
      
        // Adiciona um ouvinte de eventos para ajustar a altura quando o conteúdo é modificado
        textarea.addEventListener('input', function () {
          this.style.height = 'auto';
          this.style.height = (this.scrollHeight) + 'px';
        });
      </script>


    {{-- Modal ver usuarios da turma --}}
    <div class="modal fade" id="view-users-team-{{$team->id_teams}}" tabindex="-1" aria-labelledby="view-users-team-{{$team->id_teams}}" aria-hidden="true">
        <div class="modal-dialog" style="margin: 0 auto">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="view-users-team-{{$team->id_teams}}">Usuários da turma</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                        <div class="row" style="width: 100%; border-top: 1px solid #d3d3d3; padding-top: 15px">
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
                                    @if($isAdmin)
                                        <!-- Botão para abrir o modal -->
                                        <a style="width: 100%"  type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#remove-user-{{$user->id}}-{{$team->id_teams}}">
                                            Remover da turma
                                        </a>
                                        @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if(count($users) <=0 )
                        <h3>Nenhum usuário entrou na turma</h3>
                    @endif
                </div>
                <div class="modal-footer" style="flex-wrap: nowrap">
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
    <script src="{{asset('js/code.jquery.com_jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>

@endsection

