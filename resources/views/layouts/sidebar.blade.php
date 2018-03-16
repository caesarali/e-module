<div id="sidebar" class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            {{-- <div class="row">
                <div class="col-md-6 col-md-offset-3 profile-pict">
                    <img src="{{ asset('img/ava.jpg') }}" class="img-thumbnail img-circle">
                </div>
            </div> --}}
            <h3 class="panel-title">
                <b>
                    @if (Auth::user()->isAdmin())
                        {{ Auth::user()->username }}
                    @elseif (Auth::user()->isDosen())
                        {{ Auth::user()->dosen->name }}
                    @else
                        {{ Auth::user()->mahasiswa->name }}
                    @endif
                </b>
            </h3>
            <p class="text-muted text-center">{{ Auth::user()->email }}</p>
        </div>
        <div class="panel-body">
            <ul class="list-group">
                @if (Auth::user()->isAdmin())
                    <li class="list-group-item">
                        <a href="{{ route('module.index') }}">
                            <i class="fa fa-book fa-fw"></i> Module
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('dosen.index') }}">
                            <i class="fa fa-user-circle fa-fw"></i> Dosen
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('mahasiswa.index') }}">
                            <i class="fa fa-users fa-fw"></i> Mahasiswa
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('kelas.index') }}">
                            <i class="fa fa-cog fa-fw"></i> Kelas & Angkatan
                        </a>
                    </li>
                @else
                    <li class="list-group-item">
                        <a href="{{ route('module') }}"><i class="fa fa-book fa-fw"></i> Module</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('profile.index') }}"><i class="fa fa-fw fa-cog"></i> Edit Profile</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out fa-fw"></i> Logout
                        </a>
                    </li>
                @endif
            </ul>
      </div>
  </div>
</div>