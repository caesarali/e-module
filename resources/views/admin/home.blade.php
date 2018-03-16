@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('layouts.sidebar')

        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-7">
                            <h1 class="no-mt">{{ $modules->count() }}</h1>
                            <p class="clear-mb">Module</p>
                        </div>
                        <div class="col-md-5 text-right">
                            <i class="fa fa-book fa-5x"></i>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-center">
                    <a href="{{ route('module.index') }}">
                        Cek Detail <i class="fa fa-arrow-circle-right fa-fw"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-7">
                            <h1 class="no-mt">{{ $dosens->count() }}</h1>
                            <p class="clear-mb">Dosen</p>
                        </div>
                        <div class="col-md-5 text-right">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-center">
                    <a href="{{ route('dosen.index') }}">
                        Cek Detail <i class="fa fa-arrow-circle-right fa-fw"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-7">
                            <h1 class="no-mt">{{ $mahasiswa->count() }}</h1>
                            <p class="clear-mb">Mahasiswa</p>
                        </div>
                        <div class="col-md-5 text-right">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-center">
                    <a href="{{ route('mahasiswa.index') }}">
                        Cek Detail <i class="fa fa-arrow-circle-right fa-fw"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
