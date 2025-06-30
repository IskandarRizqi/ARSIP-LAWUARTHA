@extends('admin.layout.main')

@section('content')



<head>
   
   
    <!-- JQuery DataTable Css -->
    <link href="../../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

</head>

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
                            KATEGORI
                            </h2>
                          
                           
                        </div>
                        <div class="body">
                            <div style="text-align: right;">
                                <li>
                                    <a href="/menukategori/create" class="btn btn-primary">
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
                                            <th>Nama Kategori</th>
    
                                            <th>Aksi</th>
                                           
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                         @foreach($kategori as $key => $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{$value->nama}}</td>
                                          
                                         
                                            <td>
                                                <div class="d-flex align-items-center" style="gap: 5px; display: inline-flex;">
                                                    <!-- Tombol Edit -->
                                                    <a href="{{ route('menukategori.show', $value->id) }}" class="btn btn-primary btn-sm" 
                                                       style="padding: 4px; width: 28px; height: 28px; display: flex; justify-content: center; align-items: center; border-radius: 5px;">
                                                        <i class="material-icons" style="font-size: 16px;">edit</i>
                                                    </a>
                                            
                                                    <!-- Tombol Hapus -->
                                                    <form action="{{ route('menukategori.destroy', $value->id) }}" method="post" style="margin: 0; padding: 0; display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm show_confirm" 
                                                                style="padding: 4px; width: 28px; height: 28px; display: flex; justify-content: center; align-items: center; border-radius: 5px;">
                                                            <i class="material-icons" style="font-size: 16px;">delete</i>
                                                        </button>
                                                    </form>
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
                    
                    let form = this.closest("form");
    
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