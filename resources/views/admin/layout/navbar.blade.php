<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
        
        <!-- Ikon Logout -->
        <div class="logout-icon">
            <a href="" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="material-icons" style="color: rgb(255, 255, 255);">exit_to_app</i>
            </a>
            <form id="logout-form" action="" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
    
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="#">ARSIP WEB BANK</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                    <!-- #END# Call Search -->
                    
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span class="label-count" id="notif-count"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu" id="notif-menu">
                                    <!-- Notifikasi akan dimuat di sini menggunakan AJAX -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">View All Notifications</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="material-icons">account_circle</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li>
                                <a href="profile">
                                    <i class="material-icons">person</i> Profile
                                </a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="actionlogout" onclick="document.getElementById('logout-form').submit();">
                                    <i class="material-icons">input</i> Sign Out
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Form Logout -->
                    <form id="logout-form" action="" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <!-- More menu items... -->
                </ul>
            </div>
        </div>
    </nav>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Mengambil data user untuk mengetahui role-nya
        let userRole = '{{ Auth::user()->role }}'; // Ambil role user dari server-side (Laravel)

        // Jika role 0 atau 1, tampilkan ikon notifikasi dan ambil data notifikasi
        if (userRole == 0 || userRole == 1) {
            // Load data notifikasi menggunakan AJAX
            $.ajax({
                url: '{{ route('notifications') }}', // Menggunakan route yang sudah dibuat
                method: 'GET',
                success: function(response) {
                    let notifCount = response.length; // Menghitung jumlah notifikasi
                    $('#notif-count').text(notifCount); // Update jumlah notifikasi
                    
                    let notifHTML = ''; // String HTML untuk menyimpan notifikasi
                    if (notifCount > 0) {
                        response.forEach(function(user) {
                            notifHTML += `
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="icon-circle bg-blue-grey">
                                            <i class="material-icons">notifications</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4><b>${user.nama_user}</b> Meminta Di approve</h4>
                                            <p>
                                                <i class="material-icons">access_time</i> ${user.created_at}
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            `;
                        });
                    } else {
                        notifHTML = '<li>No pending approvals.</li>';
                    }
                    $('#notif-menu').html(notifHTML); // Update daftar notifikasi
                },
                error: function(xhr, status, error) {
                    console.log('Error fetching notifications:', error);
                }
            });
        } else {
            // Jika role bukan 0 atau 1, sembunyikan ikon notifikasi
            $('#notif-count').parent().hide(); // Menyembunyikan ikon notifikasi
        }
    });
</script>
