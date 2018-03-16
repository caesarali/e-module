<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                @guest
                    &nbsp;
                @elseif(!Auth::user()->isAdmin())
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('module') }}">Module</a></li>
                @else
                    <li><a href="{{ url('/admin') }}">Home</a></li>
                    <li><a href="{{ route('module.index') }}">Module</a></li>
                @endguest
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            @if (Auth::user()->isAdmin())
                                {{ Auth::user()->username }} 
                            @elseif (Auth::user()->isDosen())
                                {{ Auth::user()->dosen->name }} 
                            @else
                                {{ Auth::user()->mahasiswa->name }} 
                            @endif
                            <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            @if (!Auth::user()->isAdmin())
                                <li>
                                    <a href="{{ route('profile.index') }}">
                                        <i class="fa fa-cog fa-fw"></i> Edit Profile
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out fa-fw"></i>Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>