@extends('admin.layout.main')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Edit Kategori</h2>
        </div>

        <!-- Form Edit Kategori -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                   
                    <div class="body">
                        <form action="{{ route('menukategori.update', $edit->id) }}" method="POST">
                            @csrf
                            @method('PUT') <!-- Gunakan PUT untuk update data -->

                            <!-- Nama Kategori -->
                            <label for="nama">Nama Kategori</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="nama" id="nama" class="form-control" 
                                           placeholder="Masukkan Nama Kategori" value="{{ $edit->nama }}" required>
                                </div>
                            </div>

                            <!-- sub -->
                           
                            

                            <br>
                            <button type="submit" class="btn btn-success m-t-15 waves-effect">SIMPAN</button>
                            <a href="{{ route('menukategori.index') }}" class="btn btn-danger m-t-15 waves-effect">BATAL</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
