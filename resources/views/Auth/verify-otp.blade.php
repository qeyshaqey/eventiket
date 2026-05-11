<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP – EventiX</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Playfair+Display:ital@1&display=swap" rel="stylesheet">

    <style>
        :root {
            --yellow: #FFE14E;
            --navy: #192853;
            --light: #EFF8FF;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            background: var(--light);
            font-family: 'Nunito', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        /* WRAP */
        .wrap {
            display: flex;
            width: 900px;
            max-width: 100%;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 32px 80px rgba(25, 40, 83, .18);
        }

        /* LEFT */
        .left {
            flex: 0 0 46%;
            background: var(--navy);
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 32px 24px;
        }

        .blob-top {
            position: absolute;
            top: -60px;
            right: -60px;
            width: 200px;
            height: 200px;
            background: var(--yellow);
            border-radius: 50%;
            opacity: .12;
        }

        .blob-bot {
            position: absolute;
            bottom: -80px;
            left: -40px;
            width: 220px;
            height: 220px;
            background: var(--yellow);
            border-radius: 50%;
            opacity: .08;
        }

        .left-label {
            margin-top: 20px;
            text-align: center;
            z-index: 2;
        }

        .left-label h2 {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            color: var(--yellow);
            font-size: 22px;
        }

        .left-label p {
            color: rgba(255, 255, 255, .6);
            font-size: 13px;
            margin-top: 8px;
            line-height: 1.6;
        }

        /* Illustration icon */
        .otp-icon {
            width: 120px;
            height: 120px;
            background: rgba(255, 225, 78, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            position: relative;
        }

        .otp-icon svg {
            width: 60px;
            height: 60px;
        }

        /* RIGHT */
        .right {
            flex: 1;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 44px;
        }

        .right h1 {
            font-size: 26px;
            font-weight: 700;
            color: var(--navy);
            text-align: center;
            margin-bottom: 4px;
        }

        .sub {
            text-align: center;
            font-size: 13px;
            color: #8a96b0;
            margin-bottom: 28px;
            line-height: 1.6;
        }

        .email-highlight {
            font-weight: 700;
            color: var(--navy);
        }

        /* ALERT */
        .alert {
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 15px;
            font-size: 13px;
        }

        .error {
            background: #fff2f2;
            color: #c00;
        }

        .success {
            background: #f2fff5;
            color: #075;
        }

        /* OTP INPUT GROUP */
        .field {
            margin-bottom: 20px;
        }

        .field label {
            font-size: 12px;
            font-weight: 700;
            color: var(--navy);
            display: block;
            margin-bottom: 10px;
        }

        /* 6 kotak OTP terpisah */
        .otp-inputs {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .otp-inputs input {
            width: 48px;
            height: 56px;
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            color: var(--navy);
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            background: var(--light);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .otp-inputs input:focus {
            border-color: var(--navy);
            box-shadow: 0 0 0 3px rgba(25, 40, 83, 0.12);
        }

        /* Hidden input yang menyimpan nilai gabungan */
        #otp_combined {
            display: none;
        }

        /* BUTTON */
        .btn {
            width: 100%;
            padding: 14px;
            background: var(--navy);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            font-family: 'Nunito', sans-serif;
            transition: background .2s;
        }

        .btn::before {
            content: '';
            position: absolute;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 225, 78, .15), transparent);
            transition: .5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn:hover {
            background: #243a70;
        }

        /* LINK */
        .back {
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
        }

        .back a {
            color: var(--navy);
            font-weight: 700;
            text-decoration: none;
        }

        .resend {
            text-align: center;
            margin-top: 10px;
            font-size: 13px;
            color: #8a96b0;
        }

        .resend a {
            color: var(--navy);
            font-weight: 700;
            text-decoration: none;
        }

        /* Timer */
        #timer {
            color: #e53e3e;
            font-weight: 700;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body { padding: 16px; }
            .wrap { flex-direction: column; border-radius: 20px; width: 100%; }
            .left { display: none; }
            .right { padding: 32px 20px; }
            .otp-inputs input { width: 42px; height: 50px; font-size: 20px; }
        }
    </style>
</head>

<body>

    <div class="wrap">

        <!-- ═══ Left Panel ═══ -->
        <div class="left">
            <div class="blob-top"></div>
            <div class="blob-bot"></div>

            <div class="otp-icon">
                <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="8" y="16" width="48" height="36" rx="6" fill="#FFE14E" opacity=".15" stroke="#FFE14E" stroke-width="2"/>
                    <path d="M8 24l24 16 24-16" stroke="#FFE14E" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="48" cy="44" r="10" fill="#192853" stroke="#FFE14E" stroke-width="2"/>
                    <path d="M44 44l3 3 5-5" stroke="#FFE14E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <div class="left-label">
                <h2>Cek Email Anda</h2>
                <p>Kami telah mengirimkan kode OTP 6 digit ke alamat email Anda.</p>
            </div>
        </div>

        <!-- ═══ Right Panel ═══ -->
        <div class="right">

            <h1>Verifikasi OTP</h1>
            <p class="sub">
                Masukkan kode 6 digit yang dikirim ke
                <span class="email-highlight">{{ session('password_reset_email') }}</span>
            </p>

            {{-- Alert error --}}
            @if (session('error'))
                <div class="alert error">{{ session('error') }}</div>
            @endif

            {{-- Alert success --}}
            @if (session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif

            {{-- Validation error --}}
            @error('otp')
                <div class="alert error">{{ $message }}</div>
            @enderror

            <form method="POST" action="{{ route('password.verify') }}" id="otpForm">
                @csrf

                <div class="field">
                    <label style="text-align:center; display:block;">Kode OTP</label>
                    <div class="otp-inputs">
                        <input type="text" maxlength="1" class="otp-digit" inputmode="numeric" pattern="[0-9]" autocomplete="one-time-code" id="d1">
                        <input type="text" maxlength="1" class="otp-digit" inputmode="numeric" pattern="[0-9]" id="d2">
                        <input type="text" maxlength="1" class="otp-digit" inputmode="numeric" pattern="[0-9]" id="d3">
                        <input type="text" maxlength="1" class="otp-digit" inputmode="numeric" pattern="[0-9]" id="d4">
                        <input type="text" maxlength="1" class="otp-digit" inputmode="numeric" pattern="[0-9]" id="d5">
                        <input type="text" maxlength="1" class="otp-digit" inputmode="numeric" pattern="[0-9]" id="d6">
                    </div>
                    {{-- Input tersembunyi untuk mengirim nilai OTP gabungan --}}
                    <input type="hidden" name="otp" id="otp_combined">
                </div>

                <button type="submit" class="btn" id="submitBtn">Verifikasi →</button>
            </form>

            <div class="resend">
                Belum menerima kode? <span id="timer">10:00</span>
                &nbsp;|&nbsp;
                <a href="{{ route('password.forgot') }}">Kirim ulang</a>
            </div>

            <div class="back">
                <a href="{{ route('password.forgot') }}">← Kembali</a>
            </div>

        </div>
    </div>

    <script>
        // ── Auto-focus & auto-move antara kotak OTP ──
        const digits = document.querySelectorAll('.otp-digit');
        const combined = document.getElementById('otp_combined');

        digits.forEach((input, idx) => {
            input.addEventListener('input', (e) => {
                // Hanya izinkan angka
                input.value = input.value.replace(/\D/g, '').slice(-1);

                // Pindah ke kotak berikutnya
                if (input.value && idx < digits.length - 1) {
                    digits[idx + 1].focus();
                }
                syncCombined();
            });

            input.addEventListener('keydown', (e) => {
                // Backspace: pindah ke kotak sebelumnya
                if (e.key === 'Backspace' && !input.value && idx > 0) {
                    digits[idx - 1].focus();
                }
            });

            // Handle paste
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasted = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
                pasted.split('').forEach((char, i) => {
                    if (digits[i]) digits[i].value = char;
                });
                syncCombined();
                const lastFilled = Math.min(pasted.length, digits.length - 1);
                digits[lastFilled].focus();
            });
        });

        // Auto-focus kotak pertama
        digits[0].focus();

        function syncCombined() {
            combined.value = Array.from(digits).map(d => d.value).join('');
        }

        // Submit form: pastikan combined terisi
        document.getElementById('otpForm').addEventListener('submit', function (e) {
            syncCombined();
            if (combined.value.length < 6) {
                e.preventDefault();
                alert('Masukkan semua 6 digit kode OTP.');
            }
        });

        // ── Countdown timer 10 menit ──
        let totalSeconds = 10 * 60;
        const timerEl = document.getElementById('timer');

        const countdown = setInterval(() => {
            totalSeconds--;
            const m = String(Math.floor(totalSeconds / 60)).padStart(2, '0');
            const s = String(totalSeconds % 60).padStart(2, '0');
            timerEl.textContent = `${m}:${s}`;
            if (totalSeconds <= 0) {
                clearInterval(countdown);
                timerEl.textContent = 'Kedaluwarsa';
                timerEl.style.color = '#c00';
            }
        }, 1000);
    </script>

</body>
</html>
