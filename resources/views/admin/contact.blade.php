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
        
        <div class="container container-teams">
        {{-- MENSAGEM DE SUCESSO --}}
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session()->get('success')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


            <h3>Mensagens</h3>

            @foreach($contacts as $contact)
                    <div class="div-public-team" style="margin-top: 20px; padding: 20px; position:relative;">
                        {{-- Configuração --}}
                        <div class="col-2" style="position: absolute; top: 0; right: 0;z-index: 999!important;">
                            <div class="config-card-teams">
                                <ul class="navbar-nav">
                                    <li class="nav-item dropdown" style="flex-wrap: wrap;">
                                        {{-- SVG de CONFIG --}}
                                        <a class="nav-link dropdown-toggle dropdown-config-teams" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 100%; display: flex; align-items: center; ">
                                            <svg focusable="false" width="24" height="24" viewBox="0 0 24 24" class=" NMm5M">
                                                <path fill="#747373" d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
                                            </svg>
                                        </a>
                                        
                                        <ul class="dropdown-menu dropdown-100">
                                            <li>
                                                <!-- Botão para abrir o modal -->
                                                <a  type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#confirm-delete-contact-{{$contact->id_contact}}">
                                                    Apagar
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        @php
                            $dataContact = strtotime($contact->created_at);
                            $dataAtual = time();
                            $diferencaSegundos = $dataAtual - $dataContact;

                            if ($diferencaSegundos < 60) {
                                $tempo =  'há menos de um minuto';
                            } elseif ($diferencaSegundos < 3600) {
                                $minutos = floor($diferencaSegundos / 60);
                                $tempo =  'há ' . $minutos . ' minuto(s)';
                            } elseif ($diferencaSegundos < 86400) {
                                $horas = floor($diferencaSegundos / 3600);
                                $tempo =  'há ' . $horas . ' hora(s)';
                            } elseif ($diferencaSegundos < 864000) {
                                $dias = floor($diferencaSegundos / 86400);
                                if($dias == 1){
                                    $tempo =  'ontem';
                                }else{
                                    $tempo =  'há ' . $dias . ' dia(s)';
                                }
                            } else {
                                $tempo =  date('d/m/Y', $dataContact);
                            }
                        @endphp


                        <div class="row">
                            <div class="col">
                                <h2> {{-- NOME --}}
                                        {{  $contact->name  }}
                                </h2>
                                {{-- NOME DE USUARIO --}}
                                <p class="username-public-team">
                                        
                                    {{  $tempo }} - {{ "$contact->email"   }} -  {{ "$contact->phone"   }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p class="">{{ $contact->message }}</p>
                            </div>
                        </div>

                        {{-- EDITAR MENSAGEM SE FOR DO USUARIO LOGADO OU FOR ADMIN --}}
                        
                </div>
            @endforeach
        </div>


        @if(count($contacts) >=1)
            @foreach($contacts as $contact)
                <!-- Modal de Confirmação de Exclusão -->
                <div class="modal fade" id="confirm-delete-contact-{{$contact->id_contact}}" tabindex="-1" aria-labelledby="confirm-delete-contact-{{$contact->id_contact}}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirm-delete-contact-{{$contact->id_contact}}">Confirmar Exclusão</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Tem certeza de que deseja excluir essa mensagem? Não é possível recuperar os dados.
                            </div>
                            <div class="modal-footer" style="flex-wrap: nowrap">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100%">
                                    Cancelar
                                </button>

                                <form id="form-delete-contact-{{$contact->id_contact}}" action="{{ route('contact.delete', ['id_contact' => $contact->id_contact]) }}" method="post" class="d-none">
                                    @csrf
                                </form>
                                
                                <a class="btn btn-danger" style="width: 100%" onclick="event.preventDefault(); console.log(document.getElementById('form-delete-contact-{{$contact->id_contact}}')); document.getElementById('form-delete-contact-{{$contact->id_contact}}').submit();">
                                    Excluir
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        
    </body>
@endsection

