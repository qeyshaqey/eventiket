<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Baru – Eventiket</title>

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

        .lock-icon {
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
        }

        /* ALERT */
        .alert {
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 15px;
            font-size: 13px;
        }

        .error { background: #fff2f2; color: #c00; }
        .success { background: #f2fff5; color: #075; }

        /* INPUT */
        .field {
            margin-bottom: 18px;
        }

        .field label {
            font-size: 12px;
            font-weight: 700;
            color: var(--navy);
            display: block;
            margin-bottom: 6px;
        }

        .input-wrap {
            position: relative;
        }

        .input {
            width: 100%;
            padding: 13px 44px 13px 13px;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            background: var(--light);
            font-size: 14px;
            font-family: 'Nunito', sans-serif;
            outline: none;
            transition: border-color .2s;
        }

        .input:focus {
            border-color: var(--navy);
        }

        /* Toggle show/hide password */
        .toggle-pw {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #8a96b0;
            font-size: 18px;
            user-select: none;
        }

        /* Password strength bar */
        .strength-bar {
            height: 4px;
            border-radius: 4px;
            margin-top: 8px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            border-radius: 4px;
            width: 0%;
            transition: width .3s, background .3s;
        }

        .strength-text {
            font-size: 11px;
            color: #8a96b0;
            margin-top: 4px;
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
            margin-top: 4px;
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

        .btn:hover::before { left: 100%; }
        .btn:hover { background: #243a70; }

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

        /* Responsive */
        @media (max-width: 768px) {
            body { padding: 16px; }
            .wrap { flex-direction: column; border-radius: 20px; width: 100%; }
            .left { display: none; }
            .right { padding: 32px 20px; }
        }
    </style>
</head>

<body>

    <div class="wrap">

        <!-- ═══ Left Panel ═══ -->
        <div class="left">
            <div class="blob-top"></div>
            <div class="blob-bot"></div>

            <div class="lock-icon">
                <svg width="60" height="60" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="12" y="28" width="40" height="28" rx="6" fill="#FFE14E" opacity=".2" stroke="#FFE14E" stroke-width="2"/>
                    <path d="M20 28v-8a12 12 0 0 1 24 0v8" stroke="#FFE14E" stroke-width="2.5" stroke-linecap="round"/>
                    <circle cx="32" cy="42" r="4" fill="#FFE14E" opacity=".8"/>
                    <line x1="32" y1="46" x2="32" y2="50" stroke="#FFE14E" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
            </div>

            <div class="left-label">
                <h2>Password Baru</h2>
                <p>Buat password yang kuat dan mudah Anda ingat. Minimal 8 karakter.</p>
            </div>
        </div>

        <!-- ═══ Right Panel ═══ -->
        <div class="right">

            <h1>Buat Password Baru</h1>
            <p class="sub">Masukkan password baru untuk akun Anda.</p>

            {{-- Alerts --}}
            @if (session('error'))
                <div class="alert error">{{ session('error') }}</div>
            @endif
            @if (session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif
            @error('password')
                <div class="alert error">{{ $message }}</div>
            @enderror
            @error('password_confirmation')
                <div class="alert error">{{ $message }}</div>
            @enderror

            <form method="POST" action="{{ route('password.reset') }}">
                @csrf

                {{-- Password Baru --}}
                <div class="field">
                    <label for="password">Password Baru</label>
                    <div class="input-wrap">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="input"
                            placeholder="Minimal 8 karakter"
                            autocomplete="new-password"
                        >
                        <span class="toggle-pw" onclick="togglePw('password', this)">👁</span>
                    </div>
                    <div class="strength-bar">
                        <div class="strength-fill" id="strengthFill"></div>
                    </div>
                    <div class="strength-text" id="strengthText">Masukkan password untuk melihat kekuatan.</div>
                </div>

                {{-- Konfirmasi Password --}}
                <div class="field">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="input-wrap">
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="input"
                            placeholder="Ulangi password baru"
                            autocomplete="new-password"
                        >
                        <span class="toggle-pw" onclick="togglePw('password_confirmation', this)">👁</span>
                    </div>
                </div>

                <button type="submit" class="btn">Simpan Password →</button>

            </form>

            <div class="back">
                <a href="{{ route('login') }}">← Kembali ke Login</a>
            </div>

        </div>
    </div>

    <script>
        // Toggle show/hide password
        function togglePw(fieldId, icon) {
            const field = document.getElementById(fieldId);
            if (field.type === 'password') {
                field.type = 'text';
                icon.textContent = '🙈';
            } else {
                field.type = 'password';
                icon.textContent = '👁';
            }
        }

        // Password strength meter
        const pwInput = document.getElementById('password');
        const fill = document.getElementById('strengthFill');
        const text = document.getElementById('strengthText');

        pwInput.addEventListener('input', () => {
            const val = pwInput.value;
            let score = 0;

            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const levels = [
                { pct: '0%',   color: '#e2e8f0', label: 'Masukkan password untuk melihat kekuatan.' },
                { pct: '25%',  color: '#e53e3e', label: '⚠ Sangat lemah' },
                { pct: '50%',  color: '#dd6b20', label: '⚡ Lemah' },
                { pct: '75%',  color: '#d69e2e', label: '👍 Sedang' },
                { pct: '100%', color: '#38a169', label: '✅ Kuat' },
            ];

            const lvl = val.length === 0 ? levels[0] : levels[score] || levels[1];
            fill.style.width = lvl.pct;
            fill.style.background = lvl.color;
            text.textContent = lvl.label;
            text.style.color = lvl.color;
        });
    </script>

</body>
</html>
