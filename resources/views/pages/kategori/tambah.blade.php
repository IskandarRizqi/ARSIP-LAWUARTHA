@extends('admin.layout.main')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Kategori</h2>
        </div>

        <!-- Vertical Layout -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                   
                    <div class="body">
                        <form action="/menukategori" method="POST" enctype="multipart/form-data">
                            @csrf

                            <label for="email_address">Nama Kategori</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="hidden" name="idkategori" value="">
                                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukan Nama Kategori">
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


