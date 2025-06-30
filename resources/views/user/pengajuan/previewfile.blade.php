<!DOCTYPE html>
<html lang="en">
<head>
   
</head>
<body>

    <h2 style="text-align: center">PREVIEW FILE</h2>
    <iframe 
        src="{{ asset('storage/'.$xxx->file) }}#toolbar=0" 
        width="100%" 
        height="500px"
        style="border: blok;">
        {{-- /none --}}
    </iframe>

</body>
</html>

{{-- 
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Preview File</title>
</head>
<body>

    <h3>Preview File: {{ $arsip->nama }}</h3>

    @php
        $imageExtensions = ['jpg', '/jpeg', 'png', 'gif', 'bmp', 'svg'];
        $pdfExtensions = ['pdf'];
        $videoExtensions = ['mp4', 'avi', 'mov', 'wmv'];
        $audioExtensions = ['mp3', 'wav', 'ogg'];
    @endphp

    @if(in_array($fileExtension, $pdfExtensions))
        <!-- Tampilkan PDF -->
        <iframe 
            src="{{ asset('storage/' . $arsip->file) }}#toolbar=0" 
            width="100%" 
            height="600px"
            style="border: none;">
        </iframe>

    @elseif(in_array($fileExtension, $imageExtensions))
        <!-- Tampilkan Gambar -->
        <img src="{{ asset('storage/' . $arsip->file) }}" width="50%" alt="Preview Gambar">

    @elseif(in_array($fileExtension, $videoExtensions))
        <!-- Tampilkan Video -->
        <video width="70%" controls>
            <source src="{{ asset('storage/' . $arsip->file) }}" type="video/{{ $fileExtension }}">
            Browser Anda tidak mendukung pemutaran video.
        </video>

    @elseif(in_array($fileExtension, $audioExtensions))
        <!-- Tampilkan Audio -->
        <audio controls>
            <source src="{{ asset('storage/' . $arsip->file) }}" type="audio/{{ $fileExtension }}">
            Browser Anda tidak mendukung pemutaran audio.
        </audio>

    @else
        <!-- Jika file tidak bisa dipreview -->
        <p>File ini tidak dapat dipreview. Silakan <a href="{{ asset('storage/' . $arsip->file) }}" target="_blank">download di sini</a>.</p>
    @endif

</body>
</html> --}}

