@extends('layouts.app')

@section('content')
<div class="container" id="e-module">
    <div class="row">
        @include('layouts.sidebar')

        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        @if (Auth::user()->isAdmin())
                            <div class="col-md-4">
                                <a href="{{ route('module.index') }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left fa-fw"></i> <strong>Kembali</strong></a>
                            </div>
                        @else
                            <div class="col-md-4">
                                <a href="{{ route('module') }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left fa-fw"></i> <strong>Kembali</strong></a>
                            </div>
                        @endif
                        <div class="col-md-4 text-center" style="padding-top: 7px">
                            <h3 class="panel-title"><strong>Module {{ $matkul->name }}</strong></h3>
                        </div>
                        @if(!Auth::user()->isMhs())
                            <div class="col-md-4 text-right">
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#uploadModule">
                                    <strong>Upload Module</strong> <i class="fa fa-upload fa-fw"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="panel-body">
                    @if ($errors->any())
                        <div class="alert alert-danger fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            @if ($errors->has('module'))
                                <strong><i class="fa fa-exclamation-circle fa-fw" aria-hidden="true"></i> Gagal Meng-Upload! </strong> 
                                Ukuran file module yang diupload tidak boleh lebih dari 2MB.
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
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Uploader</th>
                                <th>Deskripsi</th>
                                <th>Di-Upload</th>
                                <th>Link Module</th>
                                @if(!Auth::user()->isMhs())
                                    <th>Opsi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($modules as $module)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>{{ $module->user->dosen->name or $module->user->username }}</td>
                                    <td>{{ $module->deskripsi }}</td>
                                    <td>{{ $module->created_at->diffForHumans() }}</td>
                                    <td><a href="{{ route('module.download', [$matkul->slug, $module->nama_file]) }}">Download</a></td>
                                    @if(!Auth::user()->isMhs())
                                        <td>
                                            <button class="btn btn-danger btn-xs btn-delete" onclick="destroy('{{ $module->id }}')"><i class="fa fa-trash fa-fw"></i></button>
                                            @if (Auth::user()->isAdmin())
                                                <form id="module{{ $module->id }}" action="{{ route('module.destroy', $module->id) }}" method="POST">
                                            @else
                                                <form id="module{{ $module->id }}" action="{{ route('destroy.module', $module->id) }}" method="POST">
                                            @endif
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    @if(Auth::user()->isMhs())
                                    <td colspan="5" class="text-muted text-center"><i>Belum ada module untuk matakuliah ini.</i></td>
                                    @else
                                    <td colspan="6" class="text-muted text-center"><i>Belum ada module untuk matakuliah ini.</i></td>
                                    @endif
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="text-center">
                        {{ $modules->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if(!Auth::user()->isMhs())
        <div class="row" id="modal-area">
            <div id="uploadModule" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Module</h4>
                        </div>
                        @if (Auth::user()->isAdmin())
                        <form action="{{ route('module.store') }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                        @elseif (Auth::user()->isDosen())
                        <form action="{{ route('store.module') }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                        @endif
                            <div class="modal-body">
                                {{ csrf_field() }}
                                <input type="hidden" value="{{ $matkul->id }}" name="matkul_id" required>
                                <div class="form-group">
                                    <label>Browse File: </label> <span class="text-muted"><i>( .pdf, .docx atau .doc, Ukuran maks: 2MB )</i></span>
                                    <input type="file" name="module" accept=".pdf, .doc, .docx" required>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi:</label>
                                    <textarea name="deskripsi" class="form-control" placeholder="Masukkan deskripsi tentang modul." required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-upload fa-fw"></i> Upload Module</button>
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection

@section('scripts')
<script type="text/javascript">
    function destroy(id) {
        var message = confirm('Module yang dihapus tidak dapat dikembalikan lagi. Hapus Module ?');
        if (message === true) {
            $('#module'+id).submit();
        }
    }
</script>
@endsection