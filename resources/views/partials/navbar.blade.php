<!-- Navbar utama (normal) -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-lg">
    <div class="container-fluid justify-between px-4 mx-4">
        <div class="justify-content-start">
            <a class="navbar-brand me-auto" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" />
            </a>
        </div>
        <button class="navbar-toggler text-success border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex gap-3 justify-content-end w-100 py-4">
                {{-- Tombol Masuk dan Daftar --}}
                <a class="btn btn-success px-4" href="/login">Masuk</a>
                <a class="btn btn-success px-4" href="/register">Daftar</a>
            </div>
        </div>
    </div>
</nav>

<!-- Navbar sticky (fixed) - hidden awal -->
<nav id="stickyNavbar" class="navbar navbar-expand-lg navbar-light bg-white shadow-lg fixed-top"
    style="top: 0; z-index: 1050;">
    <div class="container px-4 px-md-5">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" />
        </a>
        <button class="navbar-toggler text-success border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContentSticky" aria-controls="navbarSupportedContentSticky"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContentSticky">
            <div class="d-flex gap-3 justify-content-end w-100 py-4">
                <a href="/login" class="btn btn-success px-4">Masuk</a>
                <a href="/register" class="btn btn-success px-4">Daftar</a>
            </div>
        </div>
    </div>
</nav>
