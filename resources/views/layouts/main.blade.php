<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="{{asset('bootstrap-5.3.0-dist/css/bootstrap.min.css')}}" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="{{asset('bootstrap-5.3.0-dist/js/bootstrap.bundle.min.js')}}" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>    
    <link href="{{ asset('bootstrap-5.3.0-dist\css\bootstrap.min.css') }}" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

  @yield('content')

  <script>
      console.log('%cDesenvolvido pelo João Enrique', 'font-size: 20px; color: red;');
      console.log('%cwww.github.com/joaoenrique', 'font-size: 20px; color: red;');
  </script>

</html>