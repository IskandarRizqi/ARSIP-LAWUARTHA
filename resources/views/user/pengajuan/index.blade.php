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
                                DATA ARSIP
                            </h2>
                          
                        </div>
                        <div class="body">
                            <div style="text-align: right;">
                                <li>
                                    <a href="#" class="btn btn-primary"data-toggle="modal" data-target="#peminjamanModal">Pengajuan Peminjaman</a>
                                </li>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Waktu Upload</th>
                                            <th>Arsip</th>
                                            <th>Kategori</th>
                                            <th>Sub Kategori</th>
                                            <th>Keterangan</th>
                                            <th>Batas Waktu</th>
                                            <th>Aksi</th>
                                           
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                        @foreach($xxx as $key => $value)
                                        
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($value->created_at)->format('d M Y H:i') }}</td>
                                            <td>
                                                Arsip : {{$value->nama}} <br>
                                                Kode  : {{$value->kode}}        
                                            </td>
                                            <td>{{$value->kategori_nama}}</td>
                                            <td>{{$value->sub_nama}}</td>
                                            <td>{{$value->deskripsi}}</td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                @if(
                                                    $value->status_pengajuan == 'approved' && 
                                                    $value->jenis_arsip == 'digital' && 
                                                    $value->approved_at && 
                                                    \Carbon\Carbon::parse($value->approved_at)->diffInDays(now()) < 1 && 
                                                    now()->format('H:i') < '17:00'
                                                ) 
                                                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                                                        <div style="display: flex; gap: 5px;">
                                                          <!-- Countdown otomatis -->
                                                            <div id="countdown-display-{{ $value->id }}" 
                                                                data-approved="{{ \Carbon\Carbon::parse($value->approved_at)->toIso8601String() }}"
                                                                style="margin-top: 5px; color: red; font-weight: bold;">
                                                            --:--:--
                                                            </div>
                                                        </div>
                                                    </div>
                                            
                                                    
                                                @endif
                                            </td>
                            
                            
                                             <td style="text-align: center; vertical-align: middle;">
                                                @if(
                                                    $value->status_pengajuan == 'approved' && 
                                                    $value->jenis_arsip == 'digital' && 
                                                    $value->approved_at && 
                                                    \Carbon\Carbon::parse($value->approved_at)->diffInDays(now()) < 1 && 
                                                    now()->format('H:i') < '17:00'
                                                ) 
                                                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                                                        <div style="display: flex; gap: 5px;">
                                                            <!-- Tombol Preview -->
                                                            <a href="{{ route('preview.pdf', $value->id) }}" target="_blank" class="btn btn-info small-btn">
                                                                <i class="material-icons">visibility</i> 
                                                            </a>    
                                            
                                                            <!-- Tombol Download -->
                                                            <a href="/download?pengajuanid={{ $value->pengajuan_id }}&arsipid={{ $value->id }}" class="btn btn-danger small-btn" title="Download PDF">
                                                                <i class="material-icons">picture_as_pdf</i>
                                                            </a>

                                                           <a href="{{ route('arsip.download.zip', ['pengajuanid' => $value->pengajuan_id, 'arsipid' => $value->id]) }}" class="btn btn-success small-btn" title="Download ZIP">
                                                                <i class="material-icons">archive</i>
                                                            </a>
                                                        
                                                        </div>
                                                    </div>
                                            
                                                    
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

       <!-- Modal Form Pengajuan Peminjaman -->
        <div class="modal fade" id="peminjamanModal" tabindex="-1" aria-labelledby="peminjamanModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 style="margin-bottom: 15px" class="modal-title" id="peminjamanModalLabel">FORM PEMINJAMAN</h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('arsipkaryawan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group text-center">
                                <div class=" d-flex justify-content-center align-items-center">
                                    <!-- Radio Button Digital -->
                                    <input type="radio" id="digital" name="jenis_arsip" value="digital" class="form-check-input" required onclick="toggleForm()">
                                    <label for="digital" class="form-check-label" style="margin-right: 20px;">Digital</label>
                            
                                    <!-- Radio Button Fisik -->
                                    <input type="radio" id="fisik" name="jenis_arsip" value="fisik" class="form-check-input" required onclick="toggleForm()">
                                    <label for="fisik" class="form-check-label" >Fisik</label>
                                </div>
                            </div>

                            <br>


                         <!-- Form Digital -->
                            <div id="form_digital" style="display: none;">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="kategori">Kategori</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select id="kategori_digital" name="kategori" class="form-control select2">
                                                    <option value="">-- Pilih Kategori --</option>
                                                    @foreach($kategori as $v)
                                                        <option value="{{ $v->id }}">{{ $v->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Sub Kategori -->
                                    <div class="col-lg-6">
                                        <label for="subkategori">Sub Kategori</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select id="nama_digital" name="subkategori" class="form-control">
                                                    <option value="">-- Pilih Sub Kategori --</option>
                                                </select>
                                            </div>
                                        </div>         
                                    </div>   
                                </div>
                                <!-- Nama Arsip -->
                                <label for="arsip_digital">Nama Arsip</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select id="arsip_digital" name="namaxxx" class="form-control">
                                            <option value="">-- Pilih nama arsip --</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- type --}}
                                <label for="type">Type</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select id="type_digital" name="typexxx" class="form-control">
                                            <option value="">-- Pilih Type --</option>
                                            <option value="statis">STATIS</option>
                                            <option value="dinamis">DINAMIS</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- Tujuan --}}
                                <label for="tujuan">Tujuan</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select id="tujuan_digital" name="tujuanxxx" class="form-control">
                                            <option value="">-- Pilih Tujuan --</option>
                                            @foreach($tujuan as $v)
                                                <option value="{{ $v->nama }}">{{ $v->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                             </div>

                         <!-- Form Fisik -->
                            <div id="form_fisik" style="display: none;">

                                 <!-- Nama Arsip -->
                                 <label for="nama_digital">Nama Arsip</label>
                                 <div class="form-group">
                                     <div class="form-line">
                                         <select id="nama_digital" name="nama" class="form-control" onchange="showgetidarsip(this)">
                                             <option value="">-- Pilih Nama Arsip --</option>
                                             @foreach($vvv as $v)
                                                 <option value="{{ $v->nama }}">{{ $v->nama }}</option>
                                             @endforeach
                                         </select>
                                     </div>
                                 </div>
                                 
                                <div class="row">
                                    <!-- Lemari -->
                                    <div class="col-lg-4">
                                        <label for="lemari">Lemari</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select id="lemari" name="lemari" class="form-control">
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($lemari as $v) 
                                                        <option value="{{ $v->id }}" {{ old('lemari') == $v->id ? 'selected' : '' }}>
                                                            {{ $v->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <!-- Rak -->
                                    <div class="col-lg-4">
                                        <label for="rak">Rak</label>
                                        <div class="form-group">
                                            <div class="form-line">

                                                <select id="rak_fisik" name="rak" class="form-control">
                                                    <option value="">-- Pilih Rak --</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="1">3</option>
                                                    <option value="2">4</option>
                                                    <option value="1">5</option>
                                                    <option value="2">6</option>
                                                </select>
                                            </div>
                                        </div> 
                                    </div>
                                    {{-- No --}}
                                    <div class="col-lg-4">
                                        <label for="rak">No</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="no_fisik" name="no" class="form-control" value="{{ old('rak') }}">
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                               
                                {{-- Type --}}
                                <label for="type">Type</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select id="type_fisik" name="type" class="form-control">
                                            <option value="">-- Pilih Type --</option>
                                           <option value="statis">STATIS</option>
                                           <option value="dinamis">DINAMIS</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- Tujuan --}}
                                <label for="tujuan">Tujuan</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select id="tujuan_fisik" name="tujuan" class="form-control">
                                            <option value="">-- Pilih Tujuan --</option>
                                            @foreach($tujuan as $v)
                                                <option value="{{ $v->nama }}">{{ $v->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>   
                            </div>

                            <button type="submit" class="btn btn-primary">Ajukan Peminjaman</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Ambil elemen radio button dan form
            let digitalRadio = document.getElementById("digital");
            let fisikRadio = document.getElementById("fisik");
    
            let formDigital = document.getElementById("form_digital");
            let formFisik = document.getElementById("form_fisik");
    
            let submitButton = document.querySelector('button[type="submit"]');
    
            // Pastikan form dan tombol submit tersembunyi di awal
            formDigital.style.display = "none";
            formFisik.style.display = "none";
            submitButton.style.display = "none";
    
            // Fungsi untuk menampilkan form sesuai pilihan
            function toggleForm() {
                // Sembunyikan semua form dan tombol submit
                formDigital.style.display = "none";
                formFisik.style.display = "none";
                submitButton.style.display = "none";
    
                // Jika "Digital" dipilih, tampilkan form digital
                if (digitalRadio.checked) {
                    formDigital.style.display = "block";
                    submitButton.style.display = "block";
                }
                // Jika "Fisik" dipilih, tampilkan form fisik
                else if (fisikRadio.checked) {
                    formFisik.style.display = "block";
                    submitButton.style.display = "block";
                }
            }
    
            // Tambahkan event listener ke radio button
            digitalRadio.addEventListener("change", toggleForm);
            fisikRadio.addEventListener("change", toggleForm);
        });
    </script>
    
    
  <!-- SCRIPT FORM DIGITAL-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            // Ketika kategori dipilih, ambil data subkategori dan arsip berdasarkan kategori
            $('#kategori_digital').on('change', function () {
                var kategoriId = $(this).val(); // Ambil ID kategori yang dipilih
    
                if (kategoriId) {
                    // Ambil data subkategori berdasarkan kategori
                    $.ajax({
                        url: '/getSubKategori/' + kategoriId,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('#nama_digital').empty().append('<option value="">-- Pilih Sub Kategori --</option>');
                            $.each(data, function (key, value) {
                                $('#nama_digital').append('<option value="' + value.id + '">' + value.nama + '</option>');
                            });
                        }
                    });
    
                    // Ambil data arsip berdasarkan kategori
                    $.ajax({
                        url: '/getArsipByKategori/' + kategoriId,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('#arsip_digital').empty().append('<option value="">-- Pilih Nama Arsip --</option>');
                            $.each(data, function (key, value) {
                                $('#arsip_digital').append('<option value="' + value.nama + '">' + value.nama + '</option>');
                            });
                        }
                    });
                } else {
                    $('#nama_digital').empty();
                    $('#arsip_digital').empty();
                }
            });
    
            // Ketika subkategori dipilih, ambil data arsip berdasarkan subkategori
            $('#nama_digital').on('change', function () {
                var subKategoriId = $(this).val(); // Ambil ID subkategori yang dipilih
                
                if (subKategoriId) {
                    $.ajax({
                        url: '/getArsipBySubKategori/' + subKategoriId,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('#arsip_digital').empty().append('<option value="">-- Pilih Nama Arsip --</option>');
                            $.each(data, function (key, value) {
                                $('#arsip_digital').append('<option value="' + value.nama + '">' + value.nama + '</option>');
                            });
                        }
                    });
                } else {
                    $('#arsip_digital').empty();
                }
            });
        });
    </script>

    <!-- SCRIPT FORM FISIK-->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>


        function showgetidarsip(sel) {
            // console.log('test')
            // console.log(sel.value)
            $.ajax({
                    url: '/get-arsip-details/' + sel.value,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        console.log("Detail Arsip Ditemukan:", data); // Debugging
                        if (data) {
                            $('#lemari').val(data.lemari).trigger('change');
                            $('#rak_fisik').val(data.rak);
                            $('#no_fisik').val(data.no);
                        }
                    },
                    error: function (xhr) {
                        console.error("Gagal mengambil detail arsip:", xhr.responseText);
                    }
                });
        }
    </script>
    


 
  

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

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script>
        function downloadFile(id) {
            console.log['id'];
            // Mengirim request AJAX ke server
            // $.ajax({
            //     url: '/download/' + id, // Pastikan ini sesuai dengan rute yang kamu buat
            //     type: 'GET',
            //     success: function(response) {
            //         // Jika request berhasil dan file URL ditemukan, lakukan redirect untuk mengunduh file
            //         if (response.file_url) {
            //             // Redirect ke URL file untuk memulai unduhan
            //             window.location.href = response.file_url;
            //         } else {
            //             alert('File tidak ditemukan');
            //         }
            //     },
            //     error: function(xhr, status, error) {
            //         // Jika terjadi error, tampilkan pesan kesalahan
            //         alert("Gagal mengunduh file: " + error);
            //     }
            // });
        }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function startCountdown(elementId, approvedAt) {
                let approvedTime = new Date(approvedAt);
        
                // Buat target waktu jadi jam 00:15 hari berikutnya dari approvedAt
                let targetTime = new Date(approvedTime);
                targetTime.setDate(approvedTime.getDate()); // hari berikutnya
                targetTime.setHours(17, 0, 0, 0); // jam 00:15:00
        
                function updateCountdown() {
                    let now = new Date();
                    let diff = targetTime - now;
        
                    // Jika waktu sekarang sebelum approvedAt, tampilkan "--:--:--"
                    if (now < approvedTime) {
                        document.getElementById(elementId).innerHTML = "--:--:--";
                        setTimeout(updateCountdown, 1000);
                        return;
                    }
        
                    // Jika sudah lewat dari jam 00:15
                    if (diff <= 0) {
                        // Hapus elemen countdown dan kolom tombol
                        let countdownEl = document.getElementById(elementId);
                        let countdownTd = countdownEl.closest('td');
                        if (countdownTd) {
                            let actionTd = countdownTd.nextElementSibling;
                            countdownTd.remove(); // hapus td countdown
                            if (actionTd) actionTd.remove(); // hapus td tombol
                        }
                        return;
                    }
        
                    let hours = String(Math.floor(diff / (1000 * 60 * 60))).padStart(2, '0');
                    let minutes = String(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                    let seconds = String(Math.floor((diff % (1000 * 60)) / 1000)).padStart(2, '0');
        
                    document.getElementById(elementId).innerHTML =
                        `<span class="badge badge-warning" style="color: white; background-color: orange; padding: 5px 10px; border-radius: 5px;">${hours}:${minutes}:${seconds}</span>`;
        
                    setTimeout(updateCountdown, 1000);
                }
        
                updateCountdown();
            }
        
            // Mulai countdown untuk semua elemen
            document.querySelectorAll("[id^='countdown-display-']").forEach(function (el) {
                let approvedAt = el.getAttribute("data-approved");
                startCountdown(el.id, approvedAt);
            });
        });
        </script>
        
    



    


</body>

</html>

@endsection