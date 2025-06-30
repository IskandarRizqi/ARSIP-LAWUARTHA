@extends('admin.layout.main')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Edit Petugas</h2>
        </div>

        <!-- Vertical Layout -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                   
                    <div class="body">
                        <form>
                            <label for="upload_gambar">Upload Foto</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="file" id="upload_gambar" class="form-control">
                                </div>
                            </div>

                            <label for="email_address">Nama</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="text" class="form-control" placeholder="Masukan Nama Kategori">
                                </div>
                            </div>

                            <label for="email_address">Username</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="email_address" class="form-control" placeholder="Enter your email address">
                                </div>
                            </div>

                            <label for="password">Password</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="password" id="password" class="form-control" placeholder="Enter your password">
                                </div>
                            </div>

                        
                            <br>
                            <button type="button" class="btn btn-primary m-t-15 waves-effect">SIMPAN</button>
                        </form>

                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection