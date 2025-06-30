@extends('admin.layout.main')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Petugas</h2>
        </div>

        <!-- Vertical Layout -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                   
                    <div class="body">
                        <form action="/menupetugas" method="POST" enctype="multipart/form-data">
                            @csrf

                            <label for="gambar">Upload Foto</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="hidden" name="idpetugas" value="">
                                    <input type="file" name= "gambar" id="gambar" class="file-input">
                                </div>
                            </div>
                            

                            <label for="nama">Nama</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="hidden" name="idpetugas" value="">
                                    <input type="text"  name= "nama" id="nama" class="form-control" placeholder="Masukan Nama Kategori">
                                </div>
                            </div>

                            <label for="email_address">Username</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="hidden" name="idpetugas" value="">
                                    <input type="text" name= "username" id="username" class="form-control" placeholder="Enter your email address">
                                </div>
                            </div>

                            <label for="password">Password</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="hidden" name="idpetugas" value="">
                                    <input type="text" name="password" id="password" class="form-control" placeholder="Enter your password">
                                </div>
                            </div>

                            <label for="jabatan">jabatan</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="hidden" name="idpetugas" value="">
                                    <input type="text" name="jabatan" id="jabatan" class="form-control" placeholder="Masukan Nama Kategori">
                                </div>
                            </div>

                        
                            <br>
                            <button type="submit" class="btn btn-success m-t-15 waves-effect">SIMPAN</button>
                        </form>

                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection