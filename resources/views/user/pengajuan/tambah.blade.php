@extends('admin.layout.main')

@section('content')

<head>
 <!-- JQuery DataTable Css -->
    <link href="../../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

</head>

<style>
    .small-btn {
    padding: 1px 3px; /* Mengurangi padding tombol */
    font-size: 10px;  /* Mengecilkan ukuran teks tombol */
    border-radius: 4px; /* Membuat sudut tombol lebih kecil */
}

.small-btn i {
    font-size: 12px; /* Mengurangi ukuran ikon */
}

</style>


<body class="theme-red">

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>
                    DATA ARSIP
                  
                </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA ARSIP
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">add</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="#" data-toggle="modal" data-target="#peminjamanModal">Pengajuan Peminjaman</a></li>
                                    
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Waktu Upload</th>
                                            <th>Arsip</th>
                                            <th>Kategori</th>
                                            <th>Petugas</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                           
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                        @foreach($arsip as $key => $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{$value->created_at}}</td>
                                            <td>
                                                Arsip : {{$value->nama}} <br>
                                                Kode  : {{$value->kode}}        
                                            </td>
                                           

                                            <td>{{$value->kategori}}</td>
                                            <td></td>
                                            <td>{{$value->deskripsi}}</td>
                                         
        
                                            {{-- <td>
                                                <div class="d-flex gap-1 align-items-center">
                                                    <!-- Preview File -->
                                                    <a href="{{ asset('storage/'.$value->file) }}" target="_blank" class="btn btn-info small-btn">
                                                        <i class="material-icons">visibility</i> 
                                                    </a>
                                      
                                                    <!-- Download File -->
                                                    <a href="{{ asset('storage/'.$value->file) }}" download class="btn btn-success small-btn">
                                                        <i class="material-icons">file_download</i>
                                                    </a>
                                            
                                                    <!-- Edit -->
                                                    <a href="{{ route('menuarsip.show', $value->id) }}" class="btn btn-primary small-btn">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                            
                                                    <!-- Hapus -->
                                                    <form action="{{ route('menuarsip.destroy', $value->id) }}" method="post">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger small-btn show_confirm">
                                                            <i class="material-icons">delete</i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td> --}}
                                            
                                            
                                            
                                            
                                        </tr>
                                        @endforeach
                                      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
          
        </div>

        <!-- Modal Form Pengajuan Peminjaman -->
        <div class="modal fade" id="peminjamanModal" tabindex="-1" aria-labelledby="peminjamanModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5  style="margin-bottom: 15px" class="modal-title" id="peminjamanModalLabel">FORM PEMINJAMAN</h5>
                       
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('arsipkaryawan.store') }}" method="POST">
                            @csrf
                           
                            <label for="kategori">Nama Arsip</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select id="nama" name="nama" class="form-control">
                                        <option value="">-- Pilih Nama Arsip --</option>
                                        @foreach($arsip as $v)
                                            <option value="{{ $v->nama }}" {{ old('nama') == $v->id ? 'selected' : '' }}>
                                                {{ $v->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>

                            <label for="kategori">Type</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select id="type" name="type" class="form-control">
                                        <option value="">-- Pilih Type --</option>
                                        @foreach($type as $v)
                                            <option value="{{ $v->nama }}" {{ old('type') == $v->id ? 'selected' : '' }}>
                                                {{ $v->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>

                            <label for="kategori">Kategori</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select id="kategori" name="kategori" class="form-control">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($kategori as $v)
                                            <option value="{{ $v->nama }}" {{ old('kategori') == $v->id ? 'selected' : '' }}>
                                                {{ $v->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>

                            <label for="kategori">Tujuan</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select id="tujuan" name="tujuan" class="form-control">
                                        <option value="">-- Pilih Tujuan --</option>
                                        @foreach($tujuan as $v)
                                            <option value="{{ $v->nama }}" {{ old('tujuan') == $v->id ? 'selected' : '' }}>
                                                {{ $v->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Ajukan Peminjaman</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        
    </section>

    <!-- Jquery Core Js -->
    <script src="../../plugins/jquery/jquery.min.js"></script>

 
  

    <!-- Jquery DataTable Plugin Js -->
    <script src="{{asset('../../plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('../../plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('../../plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('../../plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{asset('../../plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{asset('../../plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{asset('../../plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{asset('../../plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{asset('../../plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>

    <!-- Custom Js -->
    <script src="{{asset('../../js/admin.js')}}"></script>
    <script src="{{asset('../../js/pages/tables/jquery-datatable.js')}}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    
    


</body>

</html>

@endsection