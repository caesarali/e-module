@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('layouts.sidebar')

        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-cog fa-fw"></i> <strong>Angkatan</strong>
                </div>
                <div class="panel-body">
                    @if (session('error-angkatan'))
                        <div class="alert alert-danger fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><i class="fa fa-exclamation-circle fa-fw" aria-hidden="true"></i> Kesalahan! </strong>
                            {{ session('error-angkatan') }}
                        </div>
                    @endif
                    @if (session('success-angkatan'))
                        <div class="alert alert-success fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><i class="fa fa-check fa-fw" aria-hidden="true"></i> Berhasil! </strong> 
                            {{ session('success-angkatan') }}
                        </div>
                    @endif
                    <form action="{{ route('angkatan.store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="input-group{{ $errors->has('tahun') ? ' has-error' : '' }}">
                            <input type="text" class="form-control" name="tahun" value="{{ old('tahun') }}" placeholder="Input Tahun. Contoh: 20xx" required>
                            <div class="input-group-btn">
                                <button class="btn btn-primary" type="submit" data-toggle="tooltip" data-placement="top" title="Simpan ?">
                                    <i class="fa fa-plus fa-fw"></i>
                                </button>
                                <button class="btn btn-primary" type="reset" data-toggle="tooltip" data-placement="top" title="Reset?">
                                    <i class="fa fa-refresh fa-fw"></i>
                                </button>
                            </div>
                        </div>
                        @if ($errors->has('tahun'))
                            <div class="input-group has-error">
                                <span class="help-block">
                                    <strong>Tahun ini sudah tersimpan sebelumnya.</strong>
                                </span>
                            </div>
                        @endif
                    </form>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tahun</th>
                                <th>Total Mhs.</th>
                                <th class="text-right">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($angkatan as $angk)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>{{ $angk->tahun }}</td>
                                    <td>{{ $angk->mahasiswa->count() }}</td>
                                    <td class="text-right">
                                        <form action="{{ route('angkatan.destroy', $angk->id) }}" method="POST" onsubmit="return konfirm('angkatan')">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-xs btn-danger" type="submit">
                                                <i class="fa fa-fw fa-times"></i> HAPUS
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-muted" colspan="4"><i>Belum ada data.</i></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-cog fa-fw"></i> <strong>Kelas</strong>
                </div>
                <div class="panel-body">
                    @if (session('error-kelas'))
                        <div class="alert alert-danger fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><i class="fa fa-exclamation-circle fa-fw" aria-hidden="true"></i> Kesalahan! </strong>
                            {{ session('error-kelas') }}
                        </div>
                    @endif
                    @if (session('success-kelas'))
                        <div class="alert alert-success fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><i class="fa fa-check fa-fw" aria-hidden="true"></i> Berhasil! </strong> 
                            {{ session('success-kelas') }}
                        </div>
                    @endif
                    <form action="{{ route('kelas.store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="input-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <input type="text" class="form-control" name="name" placeholder="Nama kelas. Ex: AK, BK, CK, dst..." required maxlength="2">
                            <div class="input-group-btn">
                                <button class="btn btn-primary" type="submit" data-toggle="tooltip" data-placement="top" title="Simpan ?">
                                    <i class="fa fa-plus fa-fw"></i>
                                </button>
                                <button class="btn btn-primary" type="reset" data-toggle="tooltip" data-placement="top" title="Reset?">
                                    <i class="fa fa-refresh fa-fw"></i>
                                </button>
                            </div>
                        </div>
                        @if ($errors->has('name'))
                            <div class="input-group has-error">
                                <span class="help-block">
                                    <strong>Nama kelas sudah digunakan.</strong>
                                </span>
                            </div>
                        @endif
                    </form>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kelas</th>
                                <th class="text-right">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kelas as $kls)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>{{ $kls->name }}</td>
                                    <td class="text-right">
                                        <form action="{{ route('kelas.destroy', $kls->id) }}" method="POST" onsubmit="return konfirm('kelas')">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-xs btn-danger" type="submit">
                                                <i class="fa fa-fw fa-times"></i> HAPUS
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-muted" colspan="4"><i>Belum ada data.</i></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });

    function destroy(id) {
        var message = confirm('Akun yang dinonaktifkan tidak dapat dikembalikan. Nonaktifkan akun ini ?');
        if (message === true) {
            $('#dosen'+id).submit();
        }
    }

    function konfirm(target) {
        if (target === 'angkatan') {
            var message = confirm('Kamu yakin ingin menghapus tahun angkatan ini ?');
        } else {
            var message = confirm('Data mungkin tidak dapat dihapus apabila masih ada data mahasiswa yang berelasi dengan data kelas. Kamu yakin ingin melanjutkan menghapus data kelas ini ?');
        }

        if (message === true) {
            return true;
        }
        return false;
    }
</script>
@endsection