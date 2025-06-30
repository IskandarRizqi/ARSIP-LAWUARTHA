@extends('admin.layout.main')

@section('content')



<head>
   
   
    <!-- JQuery DataTable Css -->
    <link href="../../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

</head>

<body class="theme-red">

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>
                TYPE
                  
                </h2>
            </div>

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
                            TYPE
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">add</i>

                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="/mastertype/create" >Tambah Type</a></li>
                                    
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
                                            <th>Nama</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                           
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                         @foreach($type as $key => $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{$value->nama}}</td>
                                            <td>{{$value->deskripsi}}</td>
                                         
        
                                            <td>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <!-- Tombol Edit -->
                                                    <a href="{{ route('mastertype.show', $value->id) }}" class="btn btn-primary btn-sm">
                                                        <i class="material-icons">edit</i> <!-- Ikon Edit -->
                                                    </a>
                                            
                                                    <!-- Tombol Hapus -->
                                                    <form action="{{ route('mastertype.destroy', $value->id) }}" method="post">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-sm show_confirm">
                                                            <i class="material-icons">delete</i> <!-- Ikon Hapus -->
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


</body>

</html>

@endsection