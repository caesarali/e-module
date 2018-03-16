@extends('layouts.app')

@section('content')
<div class="container" id="e-module">
    <div class="row">
        @include('layouts.sidebar')

        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6" style="padding-top: 5px">
                            <strong>Repository E-Module</strong>  
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#creatDir">
                                <i class="fa fa-plus fa-fw"></i>
                                <b>Buat Directori Matakuliah</b>
                            </button>  
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if ($errors->any())
                                <div class="alert alert-danger fade in">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    @if ($errors->has('name'))
                                        <strong><i class="fa fa-exclamation-circle fa-fw" aria-hidden="true"></i> Gagal! </strong> 
                                        Sudah ada directory dengan nama matakuliah tersebut.
                                    @endif
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success fade in">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong><i class="fa fa-check fa-fw" aria-hidden="true"></i> Berhasil! </strong> 
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger fade in">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong><i class="fa fa-exclamation-circle fa-fw" aria-hidden="true"></i> Gagal! </strong> 
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
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
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-md-5">
                                            @if (Auth::user()->isAdmin())
                                            <button type="button" class="btn btn-primary btn-xs btn-edit" data-route="{{ route('matkul.edit', $matkul->id) }}">
                                                <i class="fa fa-pencil fa-fw"></i>
                                            </button>
                                            @else
                                            <button type="button" class="btn btn-primary btn-xs btn-edit" data-route="{{ route('edit.matkul', $matkul->id) }}">
                                                <i class="fa fa-pencil fa-fw"></i>
                                            </button>
                                            @endif
                                            <button type="button" class="btn btn-danger btn-xs" onclick="destroy('{{ $matkul->id }}')">
                                                <i class="fa fa-trash fa-fw"></i>
                                            </button>
                                            @if(Auth::user()->isAdmin())
                                            <form id="matkul{{ $matkul->id }}" action="{{ route('matkul.destroy', $matkul->id) }}" method="POST">
                                            @elseif(Auth::user()->isDosen())
                                            <form id="matkul{{ $matkul->id }}" action="{{ route('destroy.matkul', $matkul->id) }}" method="POST">
                                            @endif
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                            </form>
                                        </div>
                                        <div class="col-md-7 text-right">
                                            @if (Auth::user()->isAdmin())
                                                <a href="{{ route('module.show', $matkul->slug) }}">
                                                    Lihat Module <i class="fa fa-arrow-circle-right fa-fw" aria-hidden="true"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('show.module', $matkul->slug) }}">
                                                    Lihat Module <i class="fa fa-arrow-circle-right fa-fw" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                            <h3 class="text-center text-muted mb-4"><i>Belum ada directory...</i></h3>
                        @endforelse
                    </div>
                    <div class="row text-center">
                        {{ $matkuls->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="modal-area">
        <div id="creatDir" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Directory</h4>
                    </div>
                    @if (Auth::user()->isAdmin())
                    <form action="{{ route('matkul.store') }}" method="POST">
                    @elseif(Auth::user()->isDosen())
                    <form action="{{ route('store.matkul') }}" method="POST">
                    @endif
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="form-group">
                                        <label>Label Directory</label>
                                        <input type="text" name="name" class="form-control" placeholder="Masukkan nama matakuliah..." required autofocus>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-plus fa-fw"></i> Buat Directory</button>
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="editDir" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Directory</h4>
                    </div>
                    <form>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script type="text/javascript">
    function destroy(id) {
        var message = confirm('Hapus directory ini ?');
        if (message === true) {
            $('#matkul'+id).submit();
        }
    }

    $('.btn-edit').click(function(event) {
        var route = $(this).data('route')
        $.get(route, function(data) {
            console.log(data);
            $('#editDir form').remove();
            $('#editDir .modal-header').after(data);
            $('#editDir').modal('toggle');
        });
    });
</script>
@endsection