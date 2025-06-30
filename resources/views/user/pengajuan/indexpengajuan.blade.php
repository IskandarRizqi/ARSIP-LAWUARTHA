


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
               
                @if(session(key: 'success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DAFTAR PENGAJUAN PEMINJAMAN (MENUNGGU PERSETUJUAN)
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                  
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="/menuarsip/create">Tambah Arsip</a></li>
                                    
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
                                            <th>Nama Arsip</th>
                                            <th>Jenis Arsip</th>
                                            <th>Type</th>
                                            <th>Kategori</th>
                                            <th>Sub Kategori</th>
                                            <th>Tujuan</th>
                                            <th>Status</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                            @foreach($pengajuan as $key => $value)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $value->nama }}</td>
                                                    <td>{{ $value->jenis_arsip}}</td>
                                                    <td>{{ $value->type }}</td>
                                                    <td>{{ $value->kategori_nama }}</td>
                                                    <td>{{ $value->sub_nama}}</td>
                                                    <td>{{ $value->tujuan }}</td>
                                                    <td>
                                                        @if($value->status == 'pending')
                                                            <span class="badge badge-warning text-dark" style="background-color: orange;">Menunggu Persetujuan</span>
                                                        @elseif($value->status == 'approved')
                                                            <span class="badge badge-success" style="background-color: green;">Disetujui</span>
                                                        @elseif($value->status == 'rejected')
                                                            <span class="badge badge-danger" style="background-color: red;">Ditolak</span>
                                                        @elseif($value->status == 'returned')
                                                            <span class="badge badge-primary" style="background-color: blue;">Dikembalikan</span>
                                                        @endif
                                                    </td>
                                                    {{-- <td>
                                                        @if($value->status == 'pending') 
                                                            <form action="{{ route('approvals.approve', $value->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                                            </form>
                                                        @endif
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
    </section>

    <!-- Jquery Core Js -->
    <script src="../../plugins/jquery/jquery.min.js"></script>

 
  

    <!-- Jquery DataTable Plugin Js -->
    <script src="../../plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="../../plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="../../plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="../../plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="../../plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="../../plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="../../plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="../../plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="../../plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <!-- Custom Js -->
    <script src="../../js/admin.js"></script>
    <script src="../../js/pages/tables/jquery-datatable.js"></script>


    
    


</body>

</html>

@endsection

