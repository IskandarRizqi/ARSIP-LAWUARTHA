
@extends('admin.layout.main')
@section('content')

<style>
    .equal-height-row {
        display: flex;
        flex-wrap: wrap;
    }

    .equal-height-row > [class*='col-'] {
        display: flex;
        flex-direction: column;
    }

    .equal-height-row .card {
        flex: 1;
    }
</style>



    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD PIMPINAN</h2>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">description</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL ARSIP</div>
                            <div class="number count-to" data-from="0" data-to="{{ $totalArsip }}" data-speed="15" data-fresh-interval="20">
                                {{ $totalArsip }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">list</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL KATEGORI</div>
                            <div class="number count-to" data-from="0" data-to="{{ $totalKategori }}" data-speed="1000" data-fresh-interval="20">
                                {{ $totalKategori }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">supervisor_account</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL PETUGAS</div>
                            <div class="number count-to" data-from="0" data-to="{{ $totalPetugas }}" data-speed="1000" data-fresh-interval="20">
                                {{ $totalPetugas }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">person</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAl USER</div>
                            <div class="number count-to" data-from="0" data-to="{{ $totalUser }}" data-speed="1000" data-fresh-interval="20">
                                {{ $totalUser }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->
         <!-- PEMAKAIAN STORAGE -->
         <div class="row clearfix equal-height-row">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                    <div class="card">
                        <div class="header">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-6">
                                    <h2>PEMAKAIAN STORAGE </h2>
                                </div>
                              
                            </div>
                        </div>
                        <div class="body">
                            <canvas id="storageChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                    <div class="card">
                        <div class="body bg-white">
                            <div class="m-b--35 font-bold">Permintaan Approve</div>
                            <ul class="dashboard-stat-list">
                                @foreach($permintaanapprove as $user)
                                <li>
                                    {{ $user->nama_user }}
                                    <span class="pull-right"><b>{{ $user->total_akses }}</b> <small>AKSES</small></span>
                                </li>
                            @endforeach
                            
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- #END# CPU Usage -->
            <div class="row clearfix">
                <!-- Visitors -->
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="body bg-pink">
                            <div class="m-b--35 font-bold">FILE TERBESAR</div>
                            <ul class="dashboard-stat-list">
                                @foreach($fileTerbesar as $file)
                                <li>
                                    {{ $file->nama }} - {{ number_format($file->size / 1024, 2, ',', '.') }} MB
                                    <span class="pull-right">
                                        <i class="material-icons">trending_up</i>
                                    </span>
                                </li>
                                 @endforeach
                            
                            </ul>
                        </div>
                    </div>
                </div>

                
                <!-- #END# Visitors -->
                <!-- Latest Social Trends -->
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="body bg-cyan">
                            <div class="m-b--35 font-bold">FILE YANG BANYAK DI AKSES</div>
                            <ul class="dashboard-stat-list">
                                @foreach($filePalingDiakses as $file)
                                    <li>
                                        {{ $file->nama }} - {{ $file->total_akses }} kali diakses
                                        <span class="pull-right">
                                            <i class="material-icons">trending_up</i>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- #END# Latest Social Trends -->
                <!-- Answered Tickets -->
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="body bg-teal">
                            <div class="font-bold m-b--35">USER YANG SERING MENGAKSES</div>
                            <ul class="dashboard-stat-list">
                                @foreach($userSeringMengakses as $user)
                                <li>
                                    {{ $user->nama_user }}
                                    <span class="pull-right"><b>{{ $user->total_akses }}</b> <small>AKSES</small></span>
                                </li>
                            @endforeach
                                
                                
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- #END# Answered Tickets -->
            </div>
 
           
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('storageChart').getContext('2d');
            var storageChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], // Semua bulan
                    datasets: [{
                        label: 'Total Peminjaman Data per Bulan',
                        data: [5, 12, 8, 20, 15, 10, 18, 25, 30, 22, 17, 19], // Data peminjaman per bulan
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 2,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    Pusher.logToConsole = true;

    var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
        cluster: "{{ env('PUSHER_APP_CLUSTER') }}"
    });

    var channel = pusher.subscribe('pengajuan-channel');
    channel.bind('pengajuan-diajukan', function(data) {
        var notifMenu = document.getElementById("notif-menu");
        var notifCount = document.getElementById("notif-count");

        // Tambahkan item ke dropdown notifikasi
        var newItem = `<li>
            <a href="javascript:void(0);">
                <div class="icon-circle bg-light-green">
                    <i class="material-icons">assignment</i>
                </div>
                <div class="menu-info">
                    <h4>Pengajuan baru: ${data.pengajuan.nama}</h4>
                    <p>
                        <i class="material-icons">access_time</i> Baru saja
                    </p>
                </div>
            </a>
        </li>`;

        notifMenu.innerHTML = newItem + notifMenu.innerHTML;

        // Update jumlah notifikasi
        var count = parseInt(notifCount.innerText);
        notifCount.innerText = count + 1;
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('storageChart').getContext('2d');
    var storageChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], 
            datasets: [{
                label: 'Total Storage per Bulan (MB)', // Label umum
                data: @json($formattedData), // Data dalam MB
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 2,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Storage (MB)' // Satuan di Y-Axis
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Bulan'
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return `Total Storage per Bulan: ${tooltipItem.raw} MB`; // Tambahkan "MB" di tooltip
                        }
                    }
                }
            }
        }
    });
});

</script>




@endsection


