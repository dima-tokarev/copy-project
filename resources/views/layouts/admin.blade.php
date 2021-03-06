<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
{{--    <script src="{{'js/libs/js/jquery-1.11.0.min.js'}}"></script>--}}
    <script src="{{asset('js/dist/js/jquery.sliderPro.min.js')}}"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/attr.js') }}" ></script>
  {{--  <script src="{{ asset('js/prototype.js') }}" ></script>--}}
{{--    <script src="{{ asset('js/scriptaculous.js') }}" ></script>--}}
    <script src="{{ asset('js/lightbox-2.6.min.js') }}" ></script>

    <script src="https://cdn.tiny.cloud/1/8ya2njt9elp5ngn2o994v0hi4hw4d8ffxyjl43x6imvd68ma/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ asset('js/comment-reply.js') }}"></script>
    <script src="{{ asset('js/myscripts.js') }}"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="{{asset('js/dist/css/slider-pro.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/lightbox.css')}}"/>
{{--    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">--}}
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
{{--    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">--}}

{{--    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">--}}
    <link href="{{ asset('css/style-minifield.css') }}" rel="stylesheet">

</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
               <img style="width: 17%" src="{{asset('/storage/uploads/ortonica.jpeg')}}">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Вход') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Регистрация') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{  \App\User::find(Auth::user()->id)->roles->first()->name }} / {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{route('users.edit', \Auth::user()->id)}}">Профиль</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Выйти') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>

                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
        <!-- START MAIN NAVIGATION -->
          @yield('navigation')
       <!-- END MAIN NAVIGATION -->
    <div class="container">
    @if (count($errors) > 0)
        <div class="box error-box">

            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach

        </div>
    @endif

    @if (session('status'))
        <div class="box success-box">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="box error-box">
            {{ session('error') }}
        </div>
    @endif
    </div>
    <main class="py-4">

        @yield('content')
    </main>
</div>
<!-- START COPYRIGHT -->
@yield('footer')
<!-- END COPYRIGHT -->


<script src="{{ asset('js/context_menu.js') }}"></script>
</body>

</html>
