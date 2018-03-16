@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('layouts.sidebar')

        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6" style="padding-top: 7px">
                            <h3 class="panel-title"><strong>Daftar Dosen</strong></h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addDosenModal">
                                <i class="fa fa-plus fa-fw"></i> <b>Tambah Dosen</b>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    @if ($errors->any())
                        <div class="alert alert-danger fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            @if ($errors->has('email'))
                                <strong><i class="fa fa-exclamation-circle fa-fw" aria-hidden="true"></i> Kesalahan! </strong> 
                                Email sudah digunakan, Silahkan gunakan email address yang berbeda.
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
                                <th>Nama Dosen</th>
                                <th>Email</th>
                                <th>No. Telpon</th>
                                <th>Total Modul</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dosens as $dosen)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>{{ $dosen->name or $dosen->user->username }}</td>
                                    <td>{{ $dosen->user->email }}</td>
                                    <td>{!! $dosen->phone or '---' !!}</td>
                                    <td>{{ $dosen->user->modules->count() }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-xs btn-delete" onclick="destroy('{{ $dosen->user->id }}')">
                                            <i class="fa fa-trash fa-fw"></i>
                                        </button>
                                        <form id="dosen{{ $dosen->user->id }}" action="{{ route('dosen.destroy', $dosen->user->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-muted text-center">Belum ada data dosen...</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="modal-area">
        <div id="addDosenModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Akun Dosen</h4>
                    </div>
                    <form action="{{ route('dosen.store') }}" method="POST" class="form-horizontal">
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name" class="control-label col-sm-2">Nama:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" placeholder="Masukkan nama dosen." required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="email">Email:</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email" placeholder="Masukkan email dosen." required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <p class="text-muted"> 
                                        <b><i>Password akan digenerate menggunakan bagian dari email sebelum simbol "@".</i></b>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-plus fa-fw"></i> Tambahkan</button>
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        </div>
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
        var message = confirm('Data dosen yang dihapus tidak dapat dikembalikan. Hapus data dosen ini ?');
        if (message === true) {
            $('#dosen'+id).submit();
        }
    }
</script>
@endsection