
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
                <h2>DASHBOARD PETUGAS</h2>
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
                            <div class="text">TOTAL PENGAJUAN</div>
                            <div class="number count-to" data-from="0" data-to="{{ $totalPengajuan }}" data-speed="1000" data-fresh-interval="20">
                                {{ $totalPengajuan }}
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
                            <div class="text">Belum disetujui</div>
                            <div class="number count-to" data-from="0" data-to="{{ $PengajuanblmApp }}" data-speed="1000" data-fresh-interval="20">
                                {{ $PengajuanblmApp }}
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
            <!-- GRAFIK LINE  -->
            <div class="row clearfix equal-height-row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                    <div class="card">
                        <div class="header">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-6">
                                    <h2>DATA APPROVE PERBULAN</h2>
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

        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('storageChart').getContext('2d');
            var storageChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Total Approve per Bulan',
                        data: @json($dataChart), // Menggunakan data dari controller
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
    



@endsection


