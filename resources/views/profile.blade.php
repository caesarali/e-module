@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('layouts.sidebar')
        
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-fw fa-cog"></i> Profil
                </div>
                <div class="panel-body">
                    <form action="{{ route('profile.update', Auth::id()) }}" class="form-horizontal" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        @if (Auth::user()->isMhs())
                            <div class="form-group">
                                <label class="control-label col-sm-3">No. Induk:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="nim" disabled value="{{ Auth::user()->mahasiswa->nim }}" placeholder="Nomor Induk Mahasiswa." maxlength="9" onkeypress="return hanyaAngka(event)" required>
                                </div>
                            </div>
                            <hr>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success fade in">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong><i class="fa fa-check fa-fw" aria-hidden="true"></i> Berhasil! </strong> 
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="name" class="control-label col-sm-3">Nama:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" value="{{ $user->mahasiswa->name or $user->dosen->name }}" placeholder="Masukkan nama mahasiswa." required>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label col-sm-3">Email:</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}" placeholder="Masukkan alamat email." required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>Email tidak valid atau email telah digunakan.</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if (Auth::user()->isMhs())
                            <div class="form-group">
                                <label class="control-label col-sm-3">Angkatan:</label>
                                <div class="col-sm-5">
                                    <select name="angkatan" class="form-control" required>
                                        @foreach($angkatan as $angk)
                                            <option value="{{ $angk->id }}" {{ $angk->id == Auth::user()->mahasiswa->angkatan_id ? 'selected' : '' }}>{{ $angk->tahun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Kelas:</label>
                                <div class="col-sm-5">
                                    <select name="kelas" class="form-control" required>
                                        @foreach($kelas as $kls)
                                            <option value="{{ $kls->id }}" {{ $kls->id == Auth::user()->mahasiswa->kelas_id ? 'selected' : '' }}>
                                                {{ $kls->name . substr(Auth::user()->mahasiswa->angkatan->tahun, 2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="control-label col-sm-3">No. Telp / WA:</label>
                            <div class="col-sm-5">
                                @if(Auth::user()->isMhs())
                                <input type="text" class="form-control" name="phone" value="{{ Auth::user()->mahasiswa->phone ? Auth::user()->mahasiswa->phone : '' }}" placeholder="Ex: 08xxxxxxxxxx." maxlength="12" onkeypress="return hanyaAngka(event)" required>
                                @elseif(Auth::user()->isDosen())
                                <input type="text" class="form-control" name="phone" value="{{ Auth::user()->dosen->phone ? Auth::user()->dosen->phone : '' }}" placeholder="Ex: 08xxxxxxxxxx." maxlength="12" onkeypress="return hanyaAngka(event)" required>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3">
                                <button class="btn btn-primary"><i class="fa fa-check fa-fw"></i> Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-cog fa-fw"></i> Password
                </div>
                <div class="panel-body">
                    @if (session('success-password'))
                        <div class="alert alert-success fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><i class="fa fa-check fa-fw" aria-hidden="true"></i> Berhasil! </strong> 
                            {{ session('success-password') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.update') }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input type="password" name="current_password" class="form-control" placeholder="Passsword saat ini." required>
                            </div>
                            <span class="help-block">{{ $errors->first('current_password') }}</span>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="Password baru." required>
                            </div>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    Password konfirmasi tidak cocok
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Password konfirmasi." required>
                            </div>
                            <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-check"></i> Ubah Password</button>
                        <button type="reset" class="btn btn-default">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        function hanyaAngka(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    </script>
@endsection