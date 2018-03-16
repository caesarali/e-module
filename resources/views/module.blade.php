@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('layouts.sidebar')

        <div class="col-md-9">
            @forelse ($matkuls as $matkul)
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <h1 class="no-mt clear-mb">{{ $matkul->module->count() }}</h1>
                                </div>
                                <div class="col-md-5 text-right">
                                    <i class="fa fa-folder-open fa-3x"></i>
                                </div>
                                <div class="col-md-12">
                                    <p class="clear-mb">{{ $matkul->name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-center">
                            <a href="{{ route('show.module', $matkul->slug) }}">
                                Lihat Module <i class="fa fa-arrow-circle-right fa-fw" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="jumbotron">
                    <h3 class="text-center text-muted"><i>Belum ada module.</i></h3>
                </div>
            @endforelse

            <div class="row text-center">
                <div class="col-md-12">
                    {{ $matkuls->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
