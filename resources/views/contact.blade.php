
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact | Eventiket</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    :root {
        --navy: #192853;
        --cream: #EFF8FF;
        --yellow: #FFE14E;
        --white: #ffffff;
        --gray: #475569;
        --shadow: 0 18px 55px rgba(25,40,83,0.12);
        --radius: 22px;
    }

    body {
        margin: 0;
        font-family: 'Inter', system-ui, sans-serif;
        background: #f8fbff;
        color: var(--navy);
    }

    .page-hero {
      padding: 60px 24px 42px;
      text-align: center;
      background: radial-gradient(circle at top, rgba(255,225,78,0.18), transparent 40%), var(--navy);
      color: var(--white);
      position: relative;
      overflow: hidden;
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

    .container {
        max-width: 1140px;
        margin: 0 auto;
        padding: 0 24px;
    }

    .contact-section { padding: 72px 0; background: var(--cream); }

    .contact-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(0, 0.8fr);
        gap: 40px;
        align-items: start;
    }

    /* INFO CARDS */
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
        /* background: var(--yellow); */
        color: var(--yellow);
    }
    .info-text h4 {
        font-family: 'Syne', sans-serif;
        font-size: 15px;
        font-weight: 700;
        color: var(--navy);
        margin-bottom: 4px;
    }

    .info-text p { font-size: 14px; color: var(--gray); line-height: 1.6; }

    .info-text a { color: var(--navy); text-decoration: none; font-weight: 600; }
    .info-text a:hover { color: #2563eb; }

    /* SOCIAL */
    .social-card {
        background: var(--navy);
        border-radius: var(--radius);
        padding: 24px;
    }

    .social-card h4 {
        font-family: 'Syne', sans-serif;
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

    /* FORM */
    .contact-form {
        background: var(--white);
        border-radius: var(--radius);
        padding: 40px 40px;
        box-shadow: var(--shadow);
        max-width: 100%;
    }

    .contact-form h3 {
        font-family: 'Syne', sans-serif;
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
        font-family: 'Syne', sans-serif;
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
        font-family: 'DM Sans', sans-serif;
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
        font-family: 'Syne', sans-serif;
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

    /* MAP PLACEHOLDER */
    .map-section { padding: 0 0 72px; background: var(--cream); }

    .map-placeholder {
        background: var(--navy);
        border-radius: 20px;
        height: 280px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: rgba(255,255,255,0.75);
        font-size: 16px;
        gap: 12px;
    }

    .map-placeholder i { font-size: 40px; color: var(--yellow); }

    @media (max-width: 900px) {
        .contact-grid { grid-template-columns: 1fr; }
        .form-row { grid-template-columns: 1fr; }
    }
</style>
<body>
<section class="page-hero">
    <div class="page-content">
      <span class="badge">Hubungi Kami</span>
      <h1>Ada Pertanyaan?</h1>
      <p>Kami siap membantu kamu. Hubungi tim Eventiket kapan saja!</p>
    </div>
  </section>

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
                            <input type="text" name="name" placeholder="Masukkan namu" required>
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
                </form>
            </div>

        </div>
    </div>
</section>
</body>
</html>

