@extends('layouts.no_sidebar_layout')

@section('content')
<style>
  .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 16px;
  }
  header {
    background: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 16px 0;
  }
  header .nav-links {
    list-style: none;
    display: flex;
    gap: 24px;
    margin: 0;
    padding: 0;
  }
  header .nav-links a {
    color: #4b5563;
    text-decoration: none;
  }
  header .nav-links a:hover {
    color: #16a34a;
  }
  .btn-primary {
    background-color: #16a34a;
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
  }
  .btn-primary:hover {
    background-color: #15803d;
  }

  .content {
    max-width: 800px;
    margin: 32px auto;
    padding: 16px;
  }

  .content h1 {
    text-align: center;
    font-size: 2rem;
    margin-bottom: 24px;
  }

  .content section {
    margin-bottom: 24px;
  }

  .content section h2 {
    font-size: 1.125rem;
    margin-bottom: 8px;
  }

  .footer {
    background: #f3f4f6;
    padding: 24px 0;
    text-align: center;
    font-size: 0.875rem;
    color: #6b7280;
  }

  .footer nav {
    margin-top: 8px;
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 12px;
  }

  .footer a {
    color: inherit;
    text-decoration: none;
  }

  .footer a:hover {
    color: #16a34a;
  }

  .footer img {
    height: 24px;
  }
</style>

<!-- Navbar -->
<header>
  <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 24px;">
    <nav>
      <ul class="nav-links">
        <button onclick="window.location.href='/'">Beranda</button>
        <button onclick="window.location.href='/login'">Masuk</button>
        <button onclick="window.location.href='/register'">Daftar</button>
      </ul>
    </nav>
  </div>
</header>

<!-- Content -->
<section class="content">
  <h1>Kebijakan & Privasi</h1>

  <p>
    <strong>Kebijakan Privasi Sistem Online Manajemen Sampah (AWAB)</strong> mengatur perlindungan atas informasi yang Anda berikan saat menggunakan layanan kami di
    <a href="https://www.awab.id">www.awab.id</a>. Kebijakan ini mencakup data pribadi yang dikumpulkan, penggunaan data tersebut, serta hak dan kewajiban pengguna dalam menjaga keamanan data.
  </p>

  <section>
    <h2>A. Data Pengguna</h2>
    <p>
      AWAB mengumpulkan informasi seperti nama, email, dan data lain yang diperlukan untuk menunjang layanan. Data disimpan secara elektronik dan dilindungi oleh sistem keamanan kami. Namun, AWAB tidak dapat menjamin sepenuhnya keamanan dari upaya akses ilegal oleh pihak ketiga.
    </p>
  </section>

  <section>
    <h2>B. Akun dan Keamanan</h2>
    <p>
      Pengguna bertanggung jawab penuh atas kerahasiaan kata sandi dan token akses API. AWAB menyediakan fitur seperti pemulihan kata sandi untuk membantu keamanan akun. Kami tidak bertanggung jawab atas penyalahgunaan akun akibat kelalaian pengguna.
    </p>
  </section>

  <section>
    <h2>C. Kritik dan Saran</h2>
    <p>
      Kami terbuka terhadap kritik dan saran yang dapat disampaikan melalui media sosial resmi AWAB untuk meningkatkan kualitas layanan.
    </p>
  </section>
</section>

<!-- Footer -->
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
