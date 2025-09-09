@extends('admin.layout.main')

@section('content')

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Arsip</h2>
        </div>

        <!-- Vertical Layout -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body">
                        <form action="/menuarsip" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Pilihan Digital / Fisik -->
                            <div class="form-group text-center">
                                <div class="d-flex justify-content-center align-items-center">
                                    <!-- Radio Button Digital -->
                                    <input type="radio" id="digital" name="jenis_file" value="digital" class="form-check-input"  onclick="toggleForm()" 
                                        style="appearance: none; width: 20px; height: 20px; border: 2px solid black; border-radius: 50%; display: inline-block; position: relative; cursor: pointer;">
                                    <label for="digital" class="form-check-label" style="margin-right: 20px; cursor: pointer; font-weight: bold;">Digital</label>

                                    <!-- Radio Button Fisik -->
                                    <input type="radio" id="fisik" name="jenis_file" value="fisik" class="form-check-input"  onclick="toggleForm()" 
                                        style="appearance: none; width: 20px; height: 20px; border: 2px solid black; border-radius: 50%; display: inline-block; position: relative; cursor: pointer;">
                                    <label for="fisik" class="form-check-label" style="cursor: pointer; font-weight: bold;">Fisik</label>
                                </div>
                            </div>
                            <br>

                            <!-- Form Digital -->
                            <div id="form_digital" style="display: none;">
                                <div class="row">
                                    <!-- Kolom Upload File (8 Kolom) -->
                                    <div class="col-lg-12">
                                        <label for="file">Upload File (PDF Only)</label>
                                        <div class="upload-container" style="text-align: center; padding: 20px; border: 2px dashed #0b75e6; border-radius: 10px; position: relative; cursor: pointer;">
                                            <input type="hidden" name="idarsip" value="">
                                            <input type="file" name="file" id="file" class="file-input" accept="application/pdf"
                                                style="opacity: 0; position: absolute; width: 100%; height: 100%; top: 0; left: 0;" 
                                                onchange="validateAndPreviewFile(event)">
                                            
                                            <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 40px; color: #aaa;">
                                                <i class="material-icons">touch_app</i>
                                            </span>
                                
                                            <!-- File Preview -->
                                            <div id="filePreview" style="margin-top: 20px; display: none;">
                                                <p id="fileName" style="font-size: 16px; color: #333;"></p>
                                            </div>
                                        </div>
                                    </div>
                                
                                    {{-- <!-- Kolom Input Kode Arsip (4 Kolom) -->
                                    <div class="col-lg-4">
                                        <label for="no">Size File ( Mb )</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" name="size" id="size" class="form-control" placeholder="Masukkan dalam bentuk Mb">
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                
                                <br>

                                <label for="email_address">Kode Arsip</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="kode" id="kode" class="form-control" placeholder="Masukan Nama Kategori">
                                    </div>
                                </div>

                                <label for="email_address">Nama Arsip</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukan Nama Kategori">
                                    </div>
                                </div>

                                <label for="subkategori">Kategori</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select id="subkategori" name="subkategori" class="form-control" >
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($subkategori as $k) 
                                                <option value="{{ $k->id }}">{{ $k->namakategori }} - {{ $k->subnama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <label for="deskripsi">Keterangan</label>
                                <div class="form-line">
                                    <textarea name="deskripsi" id="deskripsi" cols="30" rows="5" class="form-control no-resize" ></textarea>
                                </div>
                            </div>

                        <!-- Form Fisik -->
                            <div id="form_fisik" style="display: none;">
                                <br>
                                <label for="nama">Nama Arsip</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="namaxxx" id="nama_fisik" class="form-control" placeholder="Masukkan Nama Arsip">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="lemari">Lemari</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select id="lemari_fisik" name="lemari" class="form-control">
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
                                
                                    <div class="col-lg-4">
                                        <label for="no">No</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="no" id="no" class="form-control" placeholder="Masukkan Kode Arsip">
                                            </div>
                                        </div>
                                    </div>
                                </div>
    
                                

                                <label for="subkategori">Kategori</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select id="subkategori_fisik" name="subkategorixxx" class="form-control" >
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($subkategori as $k) 
                                                <option value="{{ $k->id }}">{{ $k->namakategori }} - {{ $k->subnama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <label for="deskripsi">Keterangan</label>
                                <div class="form-line">
                                    <textarea id="deskripsi_fisik" name="deskripsixxx" cols="30" rows="5" class="form-control no-resize" ></textarea>
                                </div>
                            </div>

                            <!-- Tombol Simpan -->
                            <button type="submit" class="btn btn-success m-t-15 waves-effect" id="submitBtn" style="display: none;">SIMPAN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function validateAndPreviewFile(event) {
        var fileInput = event.target;
        var file = fileInput.files[0];
        var filePreview = document.getElementById("filePreview");
        var fileName = document.getElementById("fileName");
    
        if (file) {
            var fileType = file.type;
            if (fileType !== "application/pdf") {
                alert("File harus berformat PDF!");
                fileInput.value = ""; // Reset input file
                filePreview.style.display = "none";
            } else {
                fileName.textContent = "File yang dipilih: " + file.name;
                filePreview.style.display = "block";
            }
        }
    }
</script>

<script>
    
    function toggleForm() {
        var selectedValue = document.querySelector('input[name="jenis_file"]:checked').value;
        document.getElementById("form_digital").style.display = (selectedValue === "digital") ? "block" : "none";
        document.getElementById("form_fisik").style.display = (selectedValue === "fisik") ? "block" : "none";
        document.getElementById("submitBtn").style.display = "block"; // Menampilkan tombol SIMPAN
    }

    function validateAndPreviewFile(event) {
        var fileInput = event.target;
        var file = fileInput.files[0];
        var filePreview = document.getElementById("filePreview");
        var fileName = document.getElementById("fileName");

        if (file) {
            var fileType = file.type;
            if (fileType !== "application/pdf") {
                alert("File harus berformat PDF!");
                fileInput.value = "";
                filePreview.style.display = "none";
            } else {
                fileName.textContent = "File yang dipilih: " + file.name;
                filePreview.style.display = "block";
            }
        }
    }
</script>

@endsection
