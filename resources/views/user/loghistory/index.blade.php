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
                {{-- <h2>
                   LOG HISTORY
                  
                </h2> --}}
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               LOG HISTORY
                            </h2>
                           
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Peminjam</th>
                                            <th>Nama Arsip</th>
                                            <th>Jenis Arsip</th>
                                            <th>Pengajuan</th>
                                            <th>Petugas </th>
                                            <th>Setujui</th>
                                            <th>Tolak</th>
                                            <th>Dikembalikan</th>                                      
                                           
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach($pengajuan as $key => $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $value->user_name ?? 'Unknown' }}</td>
                                            <td>{{$value->nama}}</td>
                                            <td>{{$value->jenis_arsip}}</td>
                                            <td>
                                                @if ($value->created_at)
                                                {{ \Carbon\Carbon::parse($value->created_at)->format('d M Y H:i')}}
                                                @endif
                                            </td>
                                            <td>
                                                {{ $value->approved_by_name ?? '-' }} 
                                            </td>
                                            <td>
                                                @if ($value->approved_at)
                                                {{ \Carbon\Carbon::parse($value->approved_at)->format('d M Y H:i')}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->rejected_at)
                                                {{ \Carbon\Carbon::parse($value->rejected_at)->format('d M Y H:i')}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->returned_at)
                                                {{ \Carbon\Carbon::parse($value->returned_at)->format('d M Y H:i')}}
                                                @endif
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