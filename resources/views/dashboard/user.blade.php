
@extends('admin.layout.main')
@section('content')



    <section class="content">
        <div class="container-fluid">
           
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
                            <div class="text">TOTAL SETUJUI</div>
                            <div class="number count-to" data-from="0" data-to="{{ $totalPeminjamanUser }}" data-speed="1000" data-fresh-interval="20">
                                {{ $totalPeminjamanUser }}
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
                            <div class="text">MEMINJAM ARSIP DIGITAL</div>
                            <div class="number count-to" data-from="0" data-to="{{ $totalPeminjamanUserdigital }}" data-speed="1000" data-fresh-interval="20">
                                {{ $totalPeminjamanUserdigital }}
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
                            <div class="text">MEMINJAM ARSIP FISIK</div>
                            <div class="number count-to" data-from="0" data-to="{{ $totalPeminjamanUserfisik }}" data-speed="1000" data-fresh-interval="20">
                                {{ $totalPeminjamanUserfisik }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->
            <!-- CPU Usage -->
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-6">
                                    <h2>DATA PEMINJAMAN PERBULAN</h2>
                                </div>
                               
                            </div>
                        </div>
                        <div class="body">
                            <canvas id="storageChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
                <!-- #END# Answered Tickets -->
            </div>

        
                <!-- #END# Browser Usage -->
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
                        data: @json($dataPeminjaman), // Data dari controller
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


