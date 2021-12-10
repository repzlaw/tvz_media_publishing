<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','TVZ Media Publish')</title>
    <!-- <meta name="keywords" content="@yield('meta_keywords','some default keywords')"> -->
    <meta name="description" content="@yield('meta_description','TVZ Media Publish')">
    <link rel="canonical" href="{{url()->current()}}"/>
    @yield('links')

    <!-- jquery cdn -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
{{-- <script src="https://kit.fontawesome.com/e4485b7921.js" crossorigin="anonymous"></script> --}}
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    <style>
            body {
                font-family: 'Nunito', sans-serif;
                background-color: #212529;
                background-image: linear-gradient(135deg, #0e47ab  0%, #052560  100%) !important;
            }
        </style>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md bg-dark navbar-dark shadow-sm">
        <div class="container ms-3">
            <a class="navbar-brand " href="/">
                TVZ Media Publishing
            </a>
        </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @if(!Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->username }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}">
                                    {{ __('Logout') }}
                                </a>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        <!-- </div> -->
    </nav>
    <div class="container-fluid">
  <div class="row">
  @if(Auth::check())
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="/">
                <i class="fa fa-home me-2"></i>
              Dashboard <span class="sr-only">(current)</span>
            </a>
          </li>
          @if (Auth::user()->type === 'Admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.user.all') }}">
                    <i class="fa fa-user-plus me-2"></i>
                User
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="fa fa-globe me-2"></i>
                Regions
                </a>
            </li>

          @endif
          <li class="nav-item">
            <a class="nav-link" href="/task">
                <i class=" fa fa-solid fa-tasks me-2 ml-2"></i>
              Task
            </a>
          </li>
          {{-- <li class="nav-item">
            <a class="nav-link" href="">
                <i class="fa fa-cog me-2"></i>
              Settings
            </a>
          </li> --}}
        </ul>
      </div>
    </nav>
  @endif
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4" style="height:100vh;">
        <div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
        @include('inc.message')

        @yield('content')
    </main>
  </div>
</div>
</div>
<!-- <script src="{{asset('js/.min.js')}}"></script> -->
@yield('scripts')
</body>
</html>
