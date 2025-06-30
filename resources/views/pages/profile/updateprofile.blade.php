@extends('admin.layout.main')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>UPDATE PROFILE</h2>
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

        <!-- Form Edit User -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2> UPDATE PROFILE</h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- Gunakan PUT untuk update data -->

                            <!-- Upload Gambar -->
                            <label for="gambar">Upload Gambar</label>
                            <div class="form-group d-flex align-items-center">
                                <div class="form-line">
                                    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*" onchange="previewImage(event)">
                                </div>
                                <div class="ml-3">
                                    <img id="preview" 
                                         src="{{ $user->gambar ? asset('storage/' . $user->gambar) : '' }}" 
                                         alt="Preview Gambar" 
                                         class="img-thumbnail" 
                                         style="max-width: 150px; {{ $user->gambar ? '' : 'display: none;' }}">
                                </div>
                            </div>

                            <!-- Nama -->
                            <label for="name">Username</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="name" id="name" class="form-control" 
                                           placeholder="Masukkan Nama" value="{{ old('name', $user->name) }}" required>
                                </div>
                            </div>

                            <!-- Email -->
                            <label for="email">Email</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="email" name="email" id="email" class="form-control" 
                                           placeholder="Masukkan Email" value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>

                            <!-- Password (Opsional) -->
                            <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
                            <div class="form-group">
                                <div class="form-line" style="position: relative;">
                                    <input type="password" name="password" id="password" class="form-control" 
                                           placeholder="Masukkan Password Baru (Opsional)">
                                    <span id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                            👁️
                                    </span>
                                </div>
                                <div id="password-strength-indicators" class="mt-2">
                                    <small id="length" class="text-muted">Minimal 8 karakter.</small>
                                    <small id="uppercase" class="text-muted">Harus ada huruf besar.</small>
                                    <small id="lowercase" class="text-muted">Harus ada huruf kecil.</small>
                                    <small id="number" class="text-muted">Harus ada angka.</small>
                                    <small id="special" class="text-muted">Harus ada karakter khusus seperti @, #, $, dll.</small><br>
                                </div>
                            </div>

                            <br>
                            <button type="submit" class="btn btn-success m-t-15 waves-effect">SIMPAN</button>
                            <a href="{{ route('menuuser.index') }}" class="btn btn-danger m-t-15 waves-effect">BATAL</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function previewImage(event) {
        var input = event.target;
        var reader = new FileReader();

        reader.onload = function() {
            var imgElement = document.getElementById('preview');
            imgElement.src = reader.result;
            imgElement.style.display = 'block';
        };

        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<script>
    // Mendapatkan elemen input password dan toggle icon
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    
    // Fungsi untuk toggle password visibility
    togglePassword.addEventListener('click', function() {
        // Jika tipe input password adalah 'password', ubah ke 'text', jika tidak ubah ke 'password'
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;

        // Ubah ikon mata sesuai dengan tipe password
        if (type === 'password') {
            togglePassword.textContent = '👁️';  // Ganti ikon ke mata tertutup
        } else {
            togglePassword.textContent = '🙈';  // Ganti ikon ke mata terbuka
        }
    });

    // Validasi password real-time
    const indicators = {
        length: document.getElementById('length'),
        uppercase: document.getElementById('uppercase'),
        lowercase: document.getElementById('lowercase'),
        number: document.getElementById('number'),
        special: document.getElementById('special')
    };

    // Cek password saat user mengetik
    passwordInput.addEventListener('input', function() {
        const password = passwordInput.value;
        const regexUppercase = /[A-Z]/;
        const regexLowercase = /[a-z]/;
        const regexNumber = /\d/;
        const regexSpecial = /[@$!%*?&]/;

        // Validasi panjang password (minimal 8 karakter)
        const validLength = password.length >= 8;

        // Update indikator
        indicators.length.style.color = validLength ? 'green' : 'red';
        indicators.uppercase.style.color = regexUppercase.test(password) ? 'green' : 'red';
        indicators.lowercase.style.color = regexLowercase.test(password) ? 'green' : 'red';
        indicators.number.style.color = regexNumber.test(password) ? 'green' : 'red';
        indicators.special.style.color = regexSpecial.test(password) ? 'green' : 'red';

        // Menyembunyikan indikator jika password memenuhi semua kriteria
        if (
            validLength &&
            regexUppercase.test(password) &&
            regexLowercase.test(password) &&
            regexNumber.test(password) &&
            regexSpecial.test(password)
        ) {
            // Menyembunyikan indikator jika semua kondisi terpenuhi
            indicators.length.style.display = 'none';
            indicators.uppercase.style.display = 'none';
            indicators.lowercase.style.display = 'none';
            indicators.number.style.display = 'none';
            indicators.special.style.display = 'none';
        } else {
            // Menampilkan indikator jika kondisi tidak terpenuhi
            indicators.length.style.display = 'block';
            indicators.uppercase.style.display = 'block';
            indicators.lowercase.style.display = 'block';
            indicators.number.style.display = 'block';
            indicators.special.style.display = 'block';
        }
    });
</script>

@endsection
