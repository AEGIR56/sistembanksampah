@extends('layouts.no_sidebar_layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/terms.css') }}">

<header>
  <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 24px;">
    <nav>
        <button onclick="window.location.href='/'">Beranda</button>
        <button onclick="window.location.href='/login'">Masuk</button>
        <button onclick="window.location.href='/register'">Daftar</button>
      </ul>
    </nav>
  </div>
</header>

<section class="content">
  <h1>Syarat & Ketentuan</h1>

  <p>
    AWAB (Al-Amin Waste Bank) adalah platform berbasis web dan mobile yang dikelola oleh Generasi Informatika Kreatif untuk mendukung pengelolaan sampah. Syarat dan Ketentuan ini mengikat antara pengguna dan AWAB mengenai hak, kewajiban, serta cara penggunaan layanan.
  </p>

  <section>
    <h2>A. Definisi</h2>
    <p>
      AWAB (Al-Amin Waste Bank) adalah platform berbasis web dan mobile yang dikelola oleh Generasi Informatika Kreatif untuk mendukung pengelolaan sampah.
    </p>
  </section>

  <section>
    <h2>B. Akun & Keamanan</h2>
    <ul>
      <li>Pengguna menyatakan cakap secara hukum untuk membuat perjanjian.</li>
      <li>Tidak ada biaya pendaftaran.</li>
      <li>AWAB berhak menindak pelanggaran tanpa pemberitahuan sebelumnya.</li>
      <li>Pengguna bertanggung jawab menjaga akun & wajib melapor jika terjadi akses tanpa izin.</li>
      <li>AWAB tidak bertanggung jawab atas kerugian akibat penyalahgunaan akun.</li>
    </ul>
  </section>

  <section>
    <h2>C. Batas Tanggung Jawab</h2>
    <p>AWAB menyediakan layanan "sebagaimana adanya", sehingga tidak ada jaminan layanan akan selalu bebas dari gangguan di luar kuasa kami.</p>
  </section>

  <section>
    <h2>D. Perubahan Ketentuan</h2>
    <p>AWAB dapat memperbarui ketentuan ini tanpa pemberitahuan sebelumnya. Penggunaan berkelanjutan berarti menyetujui perubahan yang berlaku.</p>
  </section>
</section>

<footer class="footer">
  <div class="container">
    <p>&copy; 2025</p>
    <nav>
      <img src="{{ asset('images/logo.png') }}" alt="Logo">
      <a href="terms"> Syarat & Ketentuan </a>
      <a href="policy"> Privasi </a>
    </nav>
  </div>
</footer>
@endsection
