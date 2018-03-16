<form action="{{ route('mahasiswa.update', $mhs->id) }}" method="POST" class="form-horizontal">
    <div class="modal-body">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <div class="form-group">
            <label for="name" class="control-label col-sm-2">Nama:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" value="{{ $mhs->name }}" placeholder="Masukkan nama mahasiswa." required>
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="control-label col-sm-2">No. Induk:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="nim" value="{{ $mhs->nim }}" placeholder="Nomor Induk Mahasiswa." maxlength="9" onkeypress="return hanyaAngka(event)" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Angkatan:</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" value="{{ $mhs->angkatan->tahun }}" maxlength="4" name="angkatan" placeholder="Masukkan tahun angkatan" list="angkatan" onkeypress="return hanyaAngka(event)" required>
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
                <input type="text" class="form-control" value="{{ $mhs->kelas->name }}" maxlength="2" name="kelas" placeholder="Masukkan kelas" list="kelas" required>
                <datalist id="kelas">
                    @foreach($kelas as $kls)
                        <option value="{{ $kls->name }}">
                    @endforeach
                </datalist>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check fa-fw"></i> Simpan Perubahan</button>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
    </div>
</form>