<!DOCTYPE html>
<html>
<head>
    <title>Home - Eventiket</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>

        body{
            font-family: Arial, sans-serif;
            margin:0;
            background:#f4f6f9;
        }

        /* NAVBAR */

        .navbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            background:#192853;
            padding:15px 40px;
            color:white;
        }

        .logo{
            font-size:22px;
            font-weight:bold;
        }

        /* NAV RIGHT (SEARCH STYLE) */

        .nav-right{
            display:flex;
            align-items:center;
            padding:5px 15px;
            border-radius:25px;
        }

        .nav-right a{
            text-decoration:none;
            color:#FFFFFF;
            margin:0 10px;
            padding:6px 10px;
            border-radius:20px;
            transition:0.3s;
        }

        .nav-right a:hover{
            background:#192853;
            color:white;
        }

        /* LOGIN SIGNUP */

        .login{
            color:white !important;
        }

        .signup{
            color:white !important;
        }

        /* DROPDOWN */

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropbtn {
            background: transparent;
            border: none;
            color:#192853;
            padding:6px 10px;
            border-radius:20px;
            cursor:pointer;
        }

        .dropbtn:hover {
            background:#192853;
            color:white;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            border-radius: 8px;
            overflow: hidden;
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 10px;
            display: block;
            text-decoration: none;
        }

        .dropdown-content a:hover {
            background: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* HERO */

        .hero{
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
            url('https://images.unsplash.com/photo-1501281668745-f7f57925c3b4');
            background-size:cover;
            background-position:center;
            height:350px;
            color:white;
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
            text-align:center;
        }

        .hero h1{
            font-size:40px;
            margin-bottom:10px;
        }

        .hero p{
            font-size:18px;
        }

        /* MENU */

        .menu{
            display:grid;
            grid-template-columns: repeat(auto-fit, minmax(200px,1fr));
            gap:25px;
            padding:40px;
        }

        .menu-card{
            text-decoration:none;
            background:white;
            padding:30px;
            border-radius:12px;
            text-align:center;
            box-shadow:0 4px 10px rgba(0,0,0,0.1);
            transition:0.3s;
            color:#333;
        }

        .menu-card:hover{
            transform:translateY(-5px);
            box-shadow:0 8px 20px rgba(0,0,0,0.15);
        }

        .title{
            font-size:18px;
            font-weight:bold;
        }

        /* ABOUT */

        .about{
            background:#ffffff;
            padding:40px;
            text-align:center;
        }

        .about p{
            max-width:600px;
            margin:auto;
        }

        /* CONTACT */

        .contact{
            background:#192853;
            padding:40px;
            text-align:center;
            color:white;
        }

        /* FOOTER */

        footer{
            background:#192853;
            color:white;
            text-align:center;
            padding:15px;
            margin-top:5px;
        }
        :root {
      --navy: #192853;
      --cream: #EFF8FF;
      --yellow: #FFE14E;
      --white: #ffffff;
      --gray: #475569;
      --shadow: 0 18px 55px rgba(25, 40, 83, 0.12);
      --radius: 24px;
    }

    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Inter', system-ui, sans-serif;
      background: linear-gradient(180deg, #f8fbff 0%, #eff8ff 100%);
      color: var(--navy);
    }

    .page-hero {
      padding: 60px 24px 42px;
      text-align: center;
      background: radial-gradient(circle at top, rgba(255,225,78,0.18), transparent 40%), var(--navy);
      color: var(--white);
      position: relative;
      overflow: hidden;
      margin-bottom: 32px;
    }

    .page-hero::after {
      content: '';
      position: absolute;
      inset: 0;
      opacity: 0.12;
      background: radial-gradient(circle at center, #ffe14e 0%, transparent 55%);
    }

    .page-hero .page-content {
      position: relative;
      z-index: 1;
      max-width: 900px;
      margin: 0 auto;
    }

    .page-hero .badge {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 10px 18px;
      border-radius: 999px;
      background: rgba(255,225,78,0.18);
      color: var(--yellow);
      font-size: 14px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.08em;
    }

    .page-hero h1 {
      font-size: clamp(2.6rem, 4vw, 4.5rem);
      margin: 28px 0 16px;
      line-height: 1.02;
      letter-spacing: -0.04em;
    }

    .page-hero p {
      max-width: 660px;
      margin: 0 auto;
      color: rgba(255,255,255,0.88);
      font-size: 1rem;
      line-height: 1.8;
    }

    .content {
      padding: 42px 24px 72px;
      max-width: 1440px;
      margin: 0 auto;
    }

    .event-grid {
      display: grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 24px;
    }

    @media (max-width: 1200px) {
      .event-grid {
        grid-template-columns: repeat(2, minmax(220px, 1fr));
      }
    }

    @media (max-width: 740px) {
      .event-grid {
        grid-template-columns: 1fr;
      }
    }

    .event-link {
      display: block;
      color: inherit;
      text-decoration: none;
    }

    .event-card {
      background: var(--white);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      padding: 24px;
      border: 1px solid rgba(25,40,83,0.08);
      transition: transform 0.25s ease, border-color 0.25s ease;
    }

    .event-card:hover {
      transform: translateY(-6px);
      border-color: rgba(255,225,78,0.35);
    }

    .event-card header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 16px;
      gap: 16px;
      flex-wrap: nowrap;
    }

    .event-card header > span {
      white-space: nowrap;
    }

    .event-image {
      width: 100%;
      border-radius: 22px;
      overflow: hidden;
      margin-bottom: 18px;
      background: #e2e8f0;
    }

    .event-image img {
      width: 100%;
      height: 420px;
      object-fit: cover;
      display: block;
    }

    @media (max-width: 740px) {
      .event-card header {
        flex-wrap: wrap;
      }
    }

    .event-card .category {
      padding: 9px 14px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 700;
      letter-spacing: 0.04em;
      text-transform: uppercase;
      color: var(--navy);
      background: rgba(25,40,83,0.08);
    }

    .event-card h2 {
      font-size: 1.25rem;
      margin: 0;
      line-height: 1.3;
      color: var(--navy);
    }

    .event-meta {
      display: grid;
      gap: 14px;
      margin-top: 18px;
      color: var(--gray);
      font-size: 0.98rem;
    }

    .event-meta span {
      display: inline-flex;
      align-items: center;
      gap: 10px;
    }

    .event-meta span::before {
      content: '';
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: var(--navy);
      opacity: 0.35;
    }

    .event-footer {
      margin-top: 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 12px;
    }

    .price-tag {
      color: var(--navy);
      font-weight: 700;
      font-size: 1rem;
      background: transparent;
      padding: 0;
      border-radius: 0;
      white-space: nowrap;
    }

    .status-pill {
      padding: 10px 16px;
      border-radius: 999px;
      font-size: 0.85rem;
      font-weight: 700;
      background: rgba(255,225,78,0.20);
      color: #6f5b04;
    }

    .cta-button {
      padding: 10px 16px;
      background: var(--navy);
      color: var(--white);
      border: none;
      border-radius: 999px;
      text-decoration: none;
      font-weight: 700;
      font-size: 0.85rem;
      transition: background 0.2s ease;
    }

    .cta-button:hover {
      background: #0f1f4a;
    }

    .summary-card {
      background: var(--cream);
      border-radius: var(--radius);
      padding: 26px 28px;
      margin-bottom: 28px;
      border: 1px solid rgba(25,40,83,0.08);
    }

    .summary-card h3 {
      margin: 0 0 12px;
      font-size: 1.15rem;
      color: var(--navy);
    }

    .summary-card p {
      margin: 0;
      color: #334155;
      line-height: 1.75;
    }

    /* Pagination Styles */
    .pagination-container {
      display: flex;
      justify-content: flex-end;
      margin-top: 40px;
    }

    .pagination {
      display: flex;
      gap: 8px;
      align-items: center;
    }

    .pagination li {
      list-style: none;
    }

    .pagination a,
    .pagination span {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      font-size: 14px;
      color: var(--navy);
      background: var(--white);
      border: 1px solid rgba(25,40,83,0.15);
      transition: all 0.2s ease;
    }

    .pagination .active span {
      background: var(--navy);
      color: var(--white);
      border-color: var(--navy);
    }

    .pagination a:hover {
      background: var(--yellow);
      color: var(--navy);
      border-color: var(--yellow);
    }

    .pagination .disabled span {
      opacity: 0.5;
      cursor: not-allowed;
    }

    </style>

    <style>
    .container {
        max-width: 1140px;
        margin: 0 auto;
        padding: 0 24px;
    }

    .contact-section { padding: 72px 0; background: var(--cream); }

    .contact-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 40px;
        align-items: start;
    }

    .contact-info { display: flex; flex-direction: column; gap: 18px; }

    .info-card {
        background: var(--white);
        border-radius: var(--radius);
        padding: 24px;
        box-shadow: var(--shadow);
        display: flex;
        gap: 16px;
        align-items: flex-start;
        transition: all 0.25s;
    }

    .info-card:hover { transform: translateX(4px); }

    .info-icon {
        width: 48px; height: 48px;
        background: var(--navy);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 18px;
        flex-shrink: 0;
    }
    .info-card:hover .info-icon {
        color: var(--yellow);
    }
    .info-text h4 {
        font-size: 15px;
        font-weight: 700;
        color: var(--navy);
        margin-bottom: 4px;
    }

    .info-text p { font-size: 14px; color: var(--gray); line-height: 1.6; }

    .info-text a { color: var(--navy); text-decoration: none; font-weight: 600; }
    .info-text a:hover { color: #2563eb; }

    @media (max-width: 900px) {
        .contact-grid { grid-template-columns: 1fr; }
    }

    .about-section {
        background: linear-gradient(135deg, var(--cream) 0%, rgba(255,225,78,0.1) 100%);
        padding: 100px 0 60px;
        position: relative;
        overflow: hidden;
        width: 100%;
        margin: 0;
    }

    .about-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(25,40,83,0.05)"/></svg>') repeat;
        opacity: 0.5;
    }

    .about-container {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 100%;
        margin: 0;
        padding: 0;
        text-align: center;
    }

    .about-grid {
        max-width: 1200px;
        margin: 0 auto;
    }

    .about-title {
        font-size: clamp(2.5rem, 4vw, 4.5rem);
        font-weight: 800;
        color: var(--navy);
        margin-bottom: 20px;
        animation: fadeInUp 1s ease-out;
    }

    .about-subtitle {
        font-size: 1.2rem;
        color: var(--gray);
        margin-bottom: 40px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
        animation: fadeInUp 1s ease-out 0.2s both;
    }

    .about-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .about-card {
        background: var(--white);
        border-radius: var(--radius);
        padding: 30px;
        box-shadow: var(--shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        animation: fadeInUp 1s ease-out 0.4s both;
    }

    .about-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(25,40,83,0.15);
    }

    .about-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--navy), var(--yellow));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 24px;
        margin-bottom: 20px;
        margin: 0 auto 20px;
    }

    .about-card h5 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--navy);
        margin-bottom: 10px;
    }

    .about-card p {
        color: var(--gray);
        line-height: 1.6;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* FORM */
    .contact-form {
        background: var(--white);
        border-radius: var(--radius);
        padding: 40px 40px;
        box-shadow: var(--shadow);
        max-width: 100%;
    }

    .contact-form h3 {
        font-size: 24px;
        font-weight: 800;
        color: var(--navy);
        margin-bottom: 8px;
    }

    .contact-form .sub { color: var(--gray); font-size: 14.5px; margin-bottom: 28px; }

    .form-row { display: grid; grid-template-columns: 1fr; gap: 18px; }

    .form-group { margin-bottom: 20px; }

    .form-group label {
        display: block;
        font-size: 13.5px;
        font-weight: 600;
        color: var(--navy);
        margin-bottom: 9px;
    }

    .form-group label .req { color: #ef4444; margin-left: 3px; }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 16px 18px;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        font-size: 15px;
        color: var(--navy);
        outline: none;
        transition: border-color 0.2s;
        background: var(--white);
        box-sizing: border-box;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus { border-color: var(--navy); }

    .form-group textarea { resize: vertical; min-height: 160px; }

    .submit-btn {
        width: 100%;
        padding: 14px;
        background: var(--navy);
        color: var(--white);
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .submit-btn:hover {
        background: var(--yellow);
        color: var(--navy);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(255,225,78,0.35);
    }

    /* SOCIAL */
    .social-card {
        background: var(--navy);
        border-radius: var(--radius);
        padding: 24px;
    }

    .social-card h4 {
        font-size: 15px;
        font-weight: 700;
        color: var(--white);
        margin-bottom: 16px;
    }

    .social-links { display: flex; gap: 10px; flex-wrap: wrap; }

    .social-btn {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: rgba(255,255,255,0.10);
        border: 1px solid rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 18px;
        transition: all 0.25s ease;
    }

    .social-btn:hover { background: var(--yellow); color: var(--navy); }

    /* Enhancements for beauty */
    .contact-section {
        background: linear-gradient(135deg, var(--cream) 0%, rgba(25,40,83,0.05) 100%);
        padding: 80px 0;
        position: relative;
        overflow: hidden;
    }

    .contact-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 20% 80%, rgba(255,225,78,0.1) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(25,40,83,0.05) 0%, transparent 50%);
        z-index: 0;
    }

    .contact-grid {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: start;
        animation: fadeInUp 1s ease-out;
    }

    .contact-form, .contact-info {
        animation: slideInLeft 1s ease-out;
    }

    .contact-info {
        animation: slideInRight 1s ease-out;
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .info-card {
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(25,40,83,0.1);
    }

    .social-card {
        transition: all 0.3s ease;
    }

    .social-card:hover {
        transform: scale(1.02);
    }

    @media (max-width: 900px) {
        .contact-grid { grid-template-columns: 1fr; }
        .contact-form, .contact-info {
            animation: fadeInUp 1s ease-out;
        }
    }

    </style>

    @vite('resources/css/app.css')
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="logo">Eventiket</div>

    <div class="nav-right">
        <a href="/home">Home</a>
        <a href="/">Event</a>
        <a href="/about">Tentang</a>
        <a href="/contact">Hubungi Kami</a>
        <a class="login" href="/login">Masuk</a>
        <a class="signup" href="/register">Daftar</a>
    </div>
</div>

<!-- HERO -->
<div class="hero">
    <h1>Temukan Event Terbaik Kampus</h1>
    <p>Konser, Seminar, Festival, dan banyak lagi!</p>
</div>

<!-- EVENT -->
 <section class="page-hero">
    <div class="page-content">
      <span class="badge">Etalase Event</span>
      <h1>Temukan Event Seru</h1>
    </div>
  </section>

  <main class="content">
    <div class="summary-card">
      <!-- <h3>Pilih event favoritmu</h3>
      <p>Eventiket menghadirkan etalase event yang mudah dijelajahi. Temukan agenda terbaru, lokasi, dan status pendaftaran tanpa repot.</p> -->
    </div>

    <div class="event-grid">
      @foreach ($paginatedEvents as $event)
        <article class="event-card">
          <header>
            <span class="category">{{ $event['category'] }}</span>
            <span class="status-pill">{{ $event['status'] }}</span>
          </header>

          <a href="{{ route('detail.event', ['id' => $event['id']]) }}" class="event-link">
            <div class="event-image">
              <img src="{{ asset('image/' . $event['image']) }}" alt="{{ $event['title'] }}">
            </div>
          </a>

          <h2>{{ $event['title'] }}</h2>
        </article>
      @endforeach
    </div>

    @if ($paginatedEvents->lastPage() > 1)
      <div class="pagination-container">
        <ul class="pagination">
          <li class="{{ $paginatedEvents->onFirstPage() ? 'disabled' : '' }}">
            @if ($paginatedEvents->onFirstPage())
              <span>&laquo;</span>
            @else
              <a href="{{ $paginatedEvents->previousPageUrl() }}" aria-label="Previous">&laquo;</a>
            @endif
          </li>

          @for ($i = 1; $i <= $paginatedEvents->lastPage(); $i++)
            <li class="{{ $paginatedEvents->currentPage() == $i ? 'active' : '' }}">
              @if ($paginatedEvents->currentPage() == $i)
                <span>{{ $i }}</span>
              @else
                <a href="{{ $paginatedEvents->url($i) }}">{{ $i }}</a>
              @endif
            </li>
          @endfor

          <li class="{{ $paginatedEvents->hasMorePages() ? '' : 'disabled' }}">
            @if ($paginatedEvents->hasMorePages())
              <a href="{{ $paginatedEvents->nextPageUrl() }}" aria-label="Next">&raquo;</a>
            @else
              <span>&raquo;</span>
            @endif
          </li>
        </ul>
      </div>
    @endif

<!-- TENTANG -->
<section class="about-section">
    <div class="about-container">
        <h2 class="about-title">Tentang Eventiket</h2>
        <p class="about-subtitle">Platform inovatif untuk menemukan event kampus terbaik</p>
        <div class="about-grid">
            <div class="about-card">
                <div class="about-icon"><i class="fa fa-calendar-alt"></i></div>
                <h5>Event Lengkap</h5>
                <p>Temukan berbagai acara menarik seperti konser, seminar, festival, dan kegiatan kampus lainnya dengan informasi lengkap.</p>
            </div>
            <div class="about-card">
                <div class="about-icon"><i class="fa fa-map-marker-alt"></i></div>
                <h5>Lokasi & Agenda</h5>
                <p>Ketahui lokasi acara dan agenda terbaru dengan mudah, tanpa repot mencari informasi di berbagai tempat.</p>
            </div>
            <div class="about-card">
                <div class="about-icon"><i class="fa fa-users"></i></div>
                <h5>Bergabung Bersama</h5>
                <p>Bergabunglah dengan ribuan peserta dan jadikan pengalaman kampus Anda lebih seru dan bermakna.</p>
            </div>
        </div>
    </div>
</section>

<!-- HUBUNGI KAMI -->
<section class="contact-section">
    <div class="container">
        <div class="contact-grid">

            <!-- FORM -->
            <div class="contact-form">
                <h3>Kirim Pesan</h3>
                <p class="sub">Isi formulir di bawah dan kami akan segera merespons dalam 1×24 jam.</p>

                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf
                    @if (session('success'))
                        <div style="margin-bottom:20px; padding:16px 18px; border-radius:14px; background:#F9F5E1; color:#4D4A00; border:1px solid rgba(255,225,78,0.45);">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div style="margin-bottom:20px; padding:16px 18px; border-radius:14px; background:#FFEEC5; color:#5D4B11; border:1px solid rgba(255,225,78,0.45);">
                            <strong>Masalah Validasi:</strong>
                            <ul style="margin:8px 0 0 18px; padding:0; list-style: disc;">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Lengkap <span class="req">*</span></label>
                            <input type="text" name="name" placeholder="Masukkan nama" required>
                        </div>

                        <div class="form-group">
                            <label>Email <span class="req">*</span></label>
                            <input type="email" name="email" placeholder="Masukkan email" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Subjek <span class="req">*</span></label>
                            <input type="text" name="subject" placeholder="Subjek" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Pesan <span class="req">*</span></label>
                            <textarea name="message" placeholder="Tuliskan pesanmu di sini..." required></textarea>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">
                        <i class="fa fa-paper-plane"></i> Kirim Pesan
                    </button>
                </form>
            </div>

            <!-- INFO -->
            <div class="contact-info">
                

                <div class="info-card">
                    <div class="info-icon"><i class="fa fa-envelope"></i></div>
                    <div class="info-text">
                        <h4>Email</h4>
                        <p><a href="mailto:info@eventiket.ac.id">eventiket@gmail.com</a><br>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon"><i class="fa fa-phone"></i></div>
                    <div class="info-text">
                        <h4>Telepon</h4>
                        <p><a href="tel:+6221123456">+62 21 123 4567</a><br>
                        Senin – Jumat, 08.00 – 17.00 WIB</p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon"><i class="fa fa-clock"></i></div>
                    <div class="info-text">
                        <h4>Lokasi</h4>
                        <p>Batam Center, Kota Batam<br>Kepulauan Riau, Indonesia</p>
                    </div>
                </div>

                <div class="social-card">
                    <h4><i class="fa fa-share-alt"></i>&nbsp; Media Sosial</h4>
                    <div class="social-links">
                        <a href="#" class="social-btn" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        <a href="#" class="social-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-btn" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!--FOOTER -->
<footer>
    <p>© 2026 Eventiket</p>
</footer>


</body>
</html>