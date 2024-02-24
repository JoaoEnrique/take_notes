<footer> 
    <div class="container"> 
        <div class="row"> 
            <div class="col-xs-12 col-sm-6 col-md-6"> 
                <h1>Take Notes</h1>
            <div>                                
        </div>
        <div class="">
            <ul class="navbar-nav navbar-footer" style="opacity: 1; display:flex; flex-direction:row; flex-wrap: wrap;">
                <li class="nav-item">
                    <a target="_BLANK" class="nav-link link-footer1" href="https://api.whatsapp.com/send?phone=+5528999571689&text=Take Notes">
                        <img src="{{asset('img/whatsapp.png')}}" height="40px" srcset="">
                    </a>
                </li>
                <li class="nav-item">
                    <a target="_BLANK" class="nav-link link-footer1" href="https://www.instagram.com/takenotesoficial/">
                        <img src="{{asset('img/instagram.png')}}" height="40px" srcset="">
                    </a>
                </li>
                <li class="nav-item">
                    <a target="_BLANK" class="nav-link link-footer1" href="https://www.linkedin.com/in/tamara-sant-ana-2838a76a/">
                        <img src="{{asset('img/linkedin.png')}}" height="40px" srcset="">
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6">
        <ul class="navbar-nav navbar-footer" style="opacity: 1; display:flex; flex-direction:row; flex-wrap: wrap;">
            <li class="nav-item">
                <a class="nav-link link-footer" href="/#home">
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link link-footer" href="{{route('about')}}">
                    Sobre Nós
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link link-footer" href="{{route('services')}}">
                    Serviços
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link link-footer" href="{{route('project')}}">
                    Projetos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link link-footer" href="{{route('contact')}}">
                    Contato
                </a>
            </li>
        </ul>
    </div>
</footer>