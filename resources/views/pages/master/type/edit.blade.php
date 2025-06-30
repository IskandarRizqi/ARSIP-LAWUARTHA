@extends('admin.layout.main')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Edit Type</h2>
        </div>

        <!-- Form Edit Type -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Form Edit Type</h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('mastertype.update', $edit->id) }}" method="POST">
                            @csrf
                            @method('PUT') <!-- Gunakan PUT untuk update data -->

                            <!-- Nama Type -->
                            <label for="nama">Nama Type</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="nama" id="nama" class="form-control" 
                                           placeholder="Masukkan Nama Type" value="{{ $edit->nama }}" required>
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <label for="deskripsi">Keterangan</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea name="deskripsi" id="deskripsi" cols="30" rows="5" 
                                              class="form-control no-resize" required>{{ $edit->deskripsi }}</textarea>
                                </div>
                            </div>

                            <br>
                            <button type="submit" class="btn btn-success m-t-15 waves-effect">SIMPAN</button>
                            <a href="{{ route('mastertype.index') }}" class="btn btn-danger m-t-15 waves-effect">BATAL</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
