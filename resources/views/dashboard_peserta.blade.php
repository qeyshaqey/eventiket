<!DOCTYPE html>
<html>
<head>
    <title>Home - Eventiket</title>

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
    
<!--FOOTER -->
<footer>
    <p>© 2026 Eventiket</p>
</footer>


</body>
</html>