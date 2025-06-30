@extends('admin.layout.main')

@section('content')

<section class="content">
    <div class="container-fluid">
       

        <!-- Form Edit Kategori -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Edit Kategori</h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('mastersubkategori.update', $edit->id) }}" method="POST">
                            @csrf
                            @method('PUT') <!-- Gunakan PUT untuk update data -->

                            <label for="kategori">Kategori</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select id="kategori" name="kategori" class="form-control">
                                        <option value="{{$edit->nama}}">--Pilih Kategori --</option>
                                        @foreach($kategori as $v)
                                            <option value="{{ $v->id }}" {{ old('nama') == $v->id ? 'selected' : '' }}>
                                                {{ $v->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>

                            <label for="nama">Sub Kategori</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="hidden" name="idsubkategori" value="">
                                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukan  SubKategori"
                                    value="{{ $edit->nama }}" >
                                </div>
                            </div>

                            <br>
                            <button type="submit" class="btn btn-success m-t-15 waves-effect">SIMPAN</button>
                            <a href="{{ route('mastersubkategori.index') }}" class="btn btn-danger m-t-15 waves-effect">BATAL</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
