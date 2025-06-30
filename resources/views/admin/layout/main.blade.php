<!DOCTYPE html>
<html lang="en">

<head>
    
    @include('admin.layout.head')
   
</head>

<body id="bg">
    {{-- <div id="loading-area"></div> --}}
    {{-- <div class="page-wraper"> --}}
        
        @include('admin.layout.navbar')
        @include('admin.layout.sidebar')

        <!-- Content Wrapper -->
        <main id="main">
            @if(Session::has('info'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Info!</strong>{{Session::get('info')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @yield('content')
        </main>
        {{-- @include('admin.layout.footer') --}}

        <!-- scroll top button -->
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>
    </div>

    @include('admin.layout.script')

</body>

</html>