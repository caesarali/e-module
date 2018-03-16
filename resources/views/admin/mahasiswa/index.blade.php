@extends('layouts.app')

@section('styles')
    {{-- Datatables --}}
    <link rel="stylesheet" href="{{ asset('assets/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        @include('layouts.sidebar')

        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-4" style="padding-top: 7px">
                            <h3 class="panel-title"><strong>Daftar Mahasiswa</strong></h3>
                        </div>
                        <div class="col-md-8 text-right">
                            <form id="filter" class="form-inline text-right" action="{{ route('mahasiswa.filter') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Filter : </label>
                                </div>
                                <div class="form-group">
                                    <select name="angk" class="form-control input-sm" onchange="$('#filter').submit()">
                                        <option value="*">Semua Angkatan</option>
                                        @foreach($angkatan->take(4) as $angk)
                                            <option value="{{ $angk->id }}" @if(isset($angkatanSelect) && $angkatanSelect == $angk->id) selected @endif>{{ $angk->tahun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <a href="{{ route('kelas.index') }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-cog fa-fw"></i>
                                    </a>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addMahasiswa">
                                        <i class="fa fa-plus fa-fw"></i> <b>Tambahkan Mahasiswa</b>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    @if ($errors->any())
                        <div class="alert alert-danger fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><i class="fa fa-exclamation-circle fa-fw" aria-hidden="true"></i> Kesalahan! </strong> 
                            @if ($errors->has('email'))
                                Email sudah digunakan, Silahkan gunakan email address yang berbeda.
                            @elseif($errors->has('nim'))
                                NIM sudah terdaftar atau terjadi duplikasi data.
                            @else
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
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
                    <table class="table table-hover" id="mahasiswa-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>No. Induk</th>
                                <th>Kelas</th>
                                <th>Angkatan</th>
                                <th>Email</th>
                                <th class="text-right">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mahasiswa as $mhs)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>{{ $mhs->name }}</td>
                                    <td>{{ $mhs->nim }}</td>
                                    <td>{{ $mhs->kelas->name . substr($mhs->angkatan->tahun, 2) }}</td>
                                    <td>{{ $mhs->angkatan->tahun }}</td>
                                    <td>{{ $mhs->user->email }}</td>
                                    <td class="text-right">
                                        <button class="btn btn-primary btn-xs btn-edit" data-route="{{ route('mahasiswa.edit', $mhs->id) }}">
                                            <i class="fa fa-pencil fa-fw"></i>
                                        </button>
                                        <form action="{{ route('mahasiswa.destroy', $mhs->user->id) }}" method="POST" style="display: inline" onsubmit="return konfirm()">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-danger btn-xs" type="submit">
                                                <i class="fa fa-trash fa-fw"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="modal-area">
        <div id="addMahasiswa" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Mahasiswa</h4>
                    </div>
                    <form action="{{ route('mahasiswa.store') }}" method="POST" class="form-horizontal">
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name" class="control-label col-sm-2">Nama:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" placeholder="Masukkan nama mahasiswa." required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label col-sm-2">No. Induk:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nim" placeholder="Nomor Induk Mahasiswa." maxlength="9" onkeypress="return hanyaAngka(event)" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="email">Email:</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email" placeholder="Masukkan email mahasiswa." required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">Angkatan:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" maxlength="4" name="angkatan" placeholder="Masukkan tahun angkatan" list="angkatan" onkeypress="return hanyaAngka(event)" required>
                                    <datalist id="angkatan">
                                        @foreach($angkatan as $angk)
                                            <option value="{{ $angk->tahun }}">
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">Kelas:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" maxlength="2" name="kelas" placeholder="Masukkan kelas" list="kelas" required>
                                    <datalist id="kelas">
                                        @foreach($kelas as $kls)
                                            <option value="{{ $kls->name }}">
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-plus fa-fw"></i> Tambahkan</button>
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="editMahasiswa" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Mahasiswa</h4>
                    </div>
                    <form></form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

    <script type="text/javascript">
        function hanyaAngka(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        function konfirm(target) {
            var message = confirm('Kamu yakin akan menghapus data mahasiswa ini ?');
            if (message === true) {
                return true;
            }
            return false;
        }

        $('.btn-edit').click(function(event) {
            var route = $(this).data('route');
            $.get(route, function(data) {
                $('#editMahasiswa form').remove();
                $('#editMahasiswa .modal-header').after(data);
                $('#editMahasiswa').modal('toggle');
            });
        });

        $(document).ready(function() {
            $('#mahasiswa-table').DataTable({
                "language": {
                    "url": "{{ asset('assets/Indonesian.json') }}"
                },
                'lengthChange': false,
                'info': false,
                'autoWidth': false,
                "ordering": false,
                'order': [[ 5, "desc" ]]
            });
        } );
    </script>
@endsection