@extends('admin.layout.main')

@section('content')

     <!-- Menambahkan SweetAlert2 CDN -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah User</h2>
        </div>

        <!-- Vertical Layout -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                   
                    <div class="body">
                        <form action="/menuuser" method="POST" enctype="multipart/form-data">
                            @csrf

                            <label for="nama">Username</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="hidden" name="idusers" value="">
                                    <input type="text"  name= "name" id="name" class="form-control" placeholder="Masukan Nama Kategori">
                                </div>
                            </div>

                            <label for="email_address">Email</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="hidden" name="idusers" value="">
                                    <input type="text" name= "email" id="email" class="form-control" placeholder="Enter your email address">
                                </div>
                            </div>

                            <label for="password">Password</label>
                            <div class="form-group">
                                <div class="form-line" style="position: relative;">
                                    <!-- Input password -->
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                                    
                                    <!-- Ikon mata untuk toggle -->
                                    <span id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                        👁️
                                    </span>
                                </div>

                                <!-- Indikator kekuatan password -->
                                <div id="password-strength-indicators" class="mt-2">
                                    <small id="length" class="text-muted">Minimal 8 karakter.</small>
                                    <small id="uppercase" class="text-muted">Harus ada huruf besar.</small>
                                    <small id="lowercase" class="text-muted">Harus ada huruf kecil.</small>
                                    <small id="number" class="text-muted">Harus ada angka.</small>
                                    <small id="special" class="text-muted">Harus ada karakter khusus seperti @, #, $, dll.</small><br>
                                </div>
                            </div>



                            <label for="kategori">Role</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select id="role" name="role" class="form-control">
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="0">Pimpinan</option>
                                        <option value="1">Petugas / Admin</option>
                                        <option value="2">User</option>
                                    </select>
                                    
                                </div>
                            </div>

                        
                            <br>
                            <button type="submit" class="btn btn-success m-t-15 waves-effect">SIMPAN</button>
                        </form>

                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if(session('ss'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('ss') }}",
            showConfirmButton: false,
            timer: 1500 // Menampilkan popup selama 1.5 detik
        });
    </script>
@endif


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