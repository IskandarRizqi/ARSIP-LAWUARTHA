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
            

            @if(session('success'))
            <div class="alert alert-success" id="success-alert">
                {{ session('success') }}
            </div>
            <script>
                // Setelah 2 detik, sembunyikan alert
                setTimeout(function() {
                    $('#success-alert').fadeOut('slow');
                }, 2000); // 2000 ms = 2 detik
            </script>
            @endif
            
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA ARSIP
                            </h2>
                          
                           
                        </div>
                        
                        
                        <div class="body">
                            <div style="text-align: right;">
                                <li>
                                    <a href="/menuarsip/create" class="btn btn-primary">
                                        Tambah
                                    </a>
                                </li>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Waktu Upload</th>
                                            <th>jenis File</th>
                                            <th>Arsip</th>
                                            <th>Kategori</th>
                                            <th>Sub Kategori</th>
                                            <th>Petugas Upload</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                           
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                        @foreach($arsip as $key => $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($value->created_at)->format('d M Y H:i') }}</td>
                                            <td>{{$value->jenis_file}}</td>
                                            <td>
                                                Arsip : {{$value->nama}} <br>
                                                Kode  : {{$value->kode}}        
                                            </td>
                                           

                                            <td>{{$value->kategori_nama}}</td>
                                            <td>{{$value->subkategori_nama}}</td>
                                        
                                            <td>{{ Auth::user()->name }}</td>
                                            <td>{{$value->deskripsi}}</td>
                                         
                                            <td>
                                                <div class="dropdown d-inline-block position-relative">
                                                    <!-- Ikon Settings sebagai trigger dropdown -->
                                                    <a href="#" id="fileActionMenu{{ $value->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                       class="text-primary" style="font-size: 20px; text-decoration: none;">
                                                        <i class="fa fa-cog"></i> <!-- Ikon Settings -->
                                                    </a>
                                            
                                                    <div class="dropdown-menu" aria-labelledby="fileActionMenu{{ $value->id }}" style="min-width: 90px; padding-left: 10px;">
                                                        @if($value->jenis_file === 'fisik')
                                                            <!-- Hanya Edit & Hapus -->
                                                            <a href="{{ route('menuarsip.show', $value->id) }}" style="color: black; font-size: 14px; display: block; padding: 5px 0;">Edit</a>
                                                            <form action="{{ route('menuarsip.destroy', $value->id) }}" method="post" class="delete-form" style="margin: 0; padding: 0; display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-link show_confirm" style="color: black; font-size: 14px; display: block; padding: 5px 0; border: none; background: none;">
                                                                    Hapus
                                                                </button>
                                                            </form>
                                                        @else
                                                            <!-- Preview, Download, Edit, Hapus -->
                                                            <a href="{{ asset('storage/'.$value->file) }}" style="color: black; font-size: 14px; display: block; padding: 5px 0;">Preview</a>
                                                            <a href="{{ asset('storage/'.$value->file) }}" download style="color: black; font-size: 14px; display: block; padding: 5px 0;">Download</a>
                                                            <a href="{{ route('menuarsip.show', $value->id) }}" style="color: black; font-size: 14px; display: block; padding: 5px 0;">Edit</a>
                                                            <form action="{{ route('menuarsip.destroy', $value->id) }}" method="post" class="delete-form" style="margin: 0; padding: 0; display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-link show_confirm" style="color: black; font-size: 14px; display: block; padding: 5px 0; border: none; background: none;">
                                                                    Hapus
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>                                          
                                            
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


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.show_confirm').forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault(); // Mencegah form langsung dikirim
    
                    let form = this.closest("form"); // Ambil form terdekat
    
                    Swal.fire({
                        title: "Apakah Anda yakin?",
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Ya, Hapus!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Kirim form jika user mengonfirmasi
                        }
                    });
                });
            });
        });
    </script>
    


</body>

</html>

@endsection