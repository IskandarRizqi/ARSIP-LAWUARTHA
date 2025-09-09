@extends('admin.layout.main')

@section('content')

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Edit Arsip</h2>
        </div>

        <!-- Vertical Layout -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body">
                        <form action="{{ route('menuarsip.update', $edit->id) }}" method="POST"  enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- Gunakan PUT untuk update data -->
                            

                            <!-- Pilihan Digital / Fisik -->
                            <div class="form-group text-center">
                                <div class="d-flex justify-content-center align-items-center">
                                    <!-- Radio Button Digital -->
                                    <input type="radio" id="digital" name="jenis_file" value="digital" class="form-check-input"  onclick="toggleForm()" {{ $edit->jenis_file == 'digital' ? 'checked' : '' }}
                                        style="appearance: none; width: 20px; height: 20px; border: 2px solid black; border-radius: 50%; display: inline-block; position: relative; cursor: pointer;">
                                    <label for="digital" class="form-check-label" style="margin-right: 20px; cursor: pointer; font-weight: bold;">Digital</label>

                                    <!-- Radio Button Fisik -->
                                    <input type="radio" id="fisik" name="jenis_file" value="fisik" class="form-check-input"  onclick="toggleForm()" {{ $edit->jenis_file == 'fisik' ? 'checked' : '' }}
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

                                    {{-- Tombol Lihat File Lama --}}
                                    @if($edit->file)
                                        <div style="margin-bottom:10px;">
                                            <a href="{{ asset('storage/' . $edit->file) }}" target="_blank" 
                                            class="btn btn-sm btn-primary">
                                                <i class="material-icons" style="vertical-align: middle;">picture_as_pdf</i>
                                                Lihat Dokumen Lama
                                            </a>
                                        </div>
                                    @endif

                                    <div class="upload-container" 
                                        style="text-align: center; padding: 20px; border: 2px dashed #0b75e6; border-radius: 10px; cursor: pointer; position:relative;">
                                        
                                        <input type="file" name="file" id="file" accept="application/pdf"
                                            style="opacity:0; position:absolute; width:100%; height:100%; top:0; left:0;"
                                            onchange="validateAndPreviewFile(event)">

                                        <span style="font-size:40px; color:#aaa;">
                                            <i class="material-icons">touch_app</i>
                                        </span>

                                        <!-- Preview file baru -->
                                        <div id="filePreview" style="margin-top: 20px; display: none;">
                                            <p id="fileName" style="font-size: 16px; color: #333;"></p>
                                        </div>
                                    </div>
                                </div>

                                                        
                                                            

                                </div>
                                
                                <br>

                                <label for="email_address">Kode Arsip</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="kode" id="kode" class="form-control" placeholder="Masukan Nama Kategori"
                                        value="{{ $edit->kode }}" >
                                    </div>
                                </div>

                                <label for="email_address">Nama Arsip</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukan Nama Kategori"
                                        value="{{ $edit->nama }}" >
                                    </div>
                                </div>
                                
                                <label for="subkategori">Kategori</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select id="subkategori" name="subkategori" class="form-control">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($subkategori as $k) 
                                                <option value="{{ $k->id }}" 
                                                    {{ isset($edit) && $edit->subkategori_id == $k->id ? 'selected' : '' }}>
                                                    {{ $k->kategori_nama }} - {{ $k->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                


                                <label for="deskripsi">Keterangan</label>
                                <div class="form-line">
                                    <textarea name="deskripsi" id="deskripsi" cols="30" rows="5" class="form-control no-resize">{{ old('deskripsi', $edit->deskripsi) }}</textarea>
                                </div>

                            </div>

                        <!-- Form Fisik -->
                            <div id="form_fisik" style="display: none;">
                                <br>
                                <label for="nama">Nama Arsip</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="namaxxx" id="nama_fisik" class="form-control" placeholder="Masukkan Nama Arsip"
                                        value="{{ $edit->nama}}">
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
                                                        <option value="{{ $v->id }}" 
                                                            {{ (old('lemari', $edit->lemari) == $v->id) ? 'selected' : '' }}>
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
                                                    @for($i=1; $i<=6; $i++)
                                                        <option value="{{ $i }}" {{ (old('rak', $edit->rak) == $i) ? 'selected' : '' }}>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>

                                            </div>
                                        </div> 
                                    </div>
                                
                                    <div class="col-lg-4">
                                        <label for="no">No</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="no" id="no" class="form-control" placeholder="Masukkan Kode Arsip"
                                                value="{{ $edit->no }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
    

                                 <label for="subkategori">Kategori</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select id="subkategori" name="subkategorixxx" class="form-control">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($subkategori as $k) 
                                                <option value="{{ $k->id }}" 
                                                    {{ isset($edit) && $edit->subkategori_id == $k->id ? 'selected' : '' }}>
                                                    {{ $k->kategori_nama }} - {{ $k->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <label for="deskripsi">Keterangan</label>
                                <div class="form-line">
                                    <textarea name="deskripsixxx" id="deskripsi_fisik" cols="30" rows="5" class="form-control no-resize">{{ old('deskripsi', $edit->deskripsi) }}</textarea>
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
