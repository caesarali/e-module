@if(Auth::user()->isAdmin())
<form action="{{ route('matkul.update', $matkul->id) }}" method="POST">
@else
<form action="{{ route('update.matkul', $matkul->id) }}" method="POST">
@endif
    <div class="modal-body">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="form-group">
                    <label>Label Directory</label>
                    <input type="text" value="{{ $matkul->name }}" name="name" class="form-control" placeholder="Masukkan nama matakuliah..." required>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check fa-fw"></i> Simpan Perubahab</button>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
    </div>
</form>