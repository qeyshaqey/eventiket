<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Event & Tiket</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Playfair+Display:ital@1&display=swap" rel="stylesheet">

    {{-- SEMUA CSS TETAP --}}
    <style>
        :root {
            --yellow: #FFE14E;
            --navy: #192853;
            --light: #EFF8FF;
        }

        *,
        *::before,
        *::after {
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

        /* ── Card wrapper ── */
        .wrap {
            display: flex;
            width: 900px;
            max-width: 100%;
            min-height: 500px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 32px 80px rgba(25, 40, 83, .18), 0 8px 24px rgba(25, 40, 83, .10);
        }

        /* ── Left panel ── */
        .left {
            flex: 0 0 46%;
            background: var(--navy);
            position: relative;
            overflow: hidden;
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

        .left svg {
            position: relative;
            z-index: 2;
        }

        .left-label {
            position: relative;
            z-index: 2;
            margin-top: 20px;
            text-align: center;
        }

        .left-label h2 {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 22px;
            color: var(--yellow);
            margin-bottom: 6px;
        }

        .left-label p {
            font-size: 13px;
            color: rgba(255, 255, 255, .55);
            line-height: 1.6;
        }

        /* ── Right panel ── */
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

        /* ── Alert ── */
        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13.5px;
            margin-bottom: 20px;
            border-left: 3px solid;
        }

        .alert-error {
            background: #fff2f2;
            border-color: #e00;
            color: #c00;
        }

        .alert-success {
            background: #f2fff5;
            border-color: #0a6;
            color: #075;
        }

        /* ── Form fields ── */
        .field {
            margin-bottom: 20px;
        }

        .field label {
            display: block;
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: .7px;
            text-transform: uppercase;
            color: var(--navy);
            margin-bottom: 7px;
        }

        .inp-wrap {
            position: relative;
        }

        .inp-wrap svg.ico {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            width: 15px;
            height: 15px;
            stroke: #b0bac8;
            fill: none;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
            pointer-events: none;
            transition: stroke .2s;
        }

        .inp-wrap:focus-within svg.ico {
            stroke: var(--navy);
        }

        .inp-wrap input {
            width: 100%;
            padding: 13px 14px 13px 42px;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Nunito', sans-serif;
            color: var(--navy);
            background: var(--light);
            outline: none;
            transition: border .2s, box-shadow .2s, background .2s;
        }

        .inp-wrap input:focus {
            border-color: var(--navy);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(25, 40, 83, .08);
        }

        .inp-wrap input::placeholder {
            color: #c0cdd8;
        }

        /* posisi eye */
        .eye {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            width: 20px;
            height: 20px;
        }

        /* svg */
        .eye svg {
            width: 100%;
            height: 100%;
            stroke: #94a3b8;
            fill: none;
            stroke-width: 2;
            transition: 0.2s;
        }

        .eye:hover svg {
            stroke: #192853;
        }

        /* sembunyikan salah satu icon */
        .eye-close {
            display: none;
        }

        /* toggle icon */
        #togglePass:checked~.eye .eye-open {
            display: none;
        }

        #togglePass:checked~.eye .eye-close {
            display: block;
        }

        /* ── Options row ── */
        .options-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 26px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 13px;
            color: #64748b;
            cursor: pointer;
        }

        .remember input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 16px;
            height: 16px;
            border: 1.5px solid #d0d8e4;
            border-radius: 5px;
            cursor: pointer;
            position: relative;
            transition: all .2s;
            flex-shrink: 0;
        }

        .remember input:checked {
            background: var(--navy);
            border-color: var(--navy);
        }

        .remember input:checked::after {
            content: '';
            position: absolute;
            left: 4px;
            top: 1px;
            width: 5px;
            height: 8px;
            border: 2px solid var(--yellow);
            border-top: none;
            border-left: none;
            transform: rotate(45deg);
        }

        .forgot {
            font-size: 12.5px;
            color: var(--navy);
            text-decoration: none;
            opacity: .6;
            font-weight: 600;
            transition: opacity .2s;
        }

        .forgot:hover {
            opacity: 1;
        }

        /* ── Submit button ── */
        .btn {
            width: 100%;
            padding: 14px;
            background: var(--navy);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-family: 'Nunito', sans-serif;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: transform .15s, box-shadow .2s, background .2s;
            margin-bottom: 22px;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 225, 78, .15), transparent);
            transition: left .5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn:hover {
            background: #243a70;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(25, 40, 83, .28);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn .acc {
            color: var(--yellow);
        }

        /* ── Register link ── */
        .reg {
            text-align: center;
            font-size: 13px;
            color: #94a3b8;
        }

        .reg a {
            color: var(--navy);
            font-weight: 700;
            text-decoration: none;
            border-bottom: 2px solid var(--yellow);
            padding-bottom: 1px;
            transition: opacity .2s;
        }

        .reg a:hover {
            opacity: .7;
        }

        /* ── Responsive ── */
        @media (max-width: 640px) {
            .left {
                display: none;
            }

            .right {
                padding: 40px 28px;
            }

            .wrap {
                border-radius: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="wrap">

        <!-- LEFT PANEL -->
        <div class="left">
            <div class="blob-top"></div>
            <div class="blob-bot"></div>

            @verbatim
            <svg width="260" height="300" viewBox="0 0 260 300" xmlns="http://www.w3.org/2000/svg">
                <circle cx="130" cy="150" r="110" fill="#FFE14E" opacity=".05" />
                <circle cx="130" cy="150" r="80" fill="#FFE14E" opacity=".05" />

                <!-- Main ticket -->
                <rect x="20" y="90" width="220" height="100" rx="14" fill="#FFE14E" />
                <circle cx="20" cy="140" r="12" fill="#192853" />
                <circle cx="240" cy="140" r="12" fill="#192853" />
                <line x1="32" y1="140" x2="228" y2="140" stroke="#192853" stroke-width="1.5" stroke-dasharray="6 5" opacity=".3" />
                <text x="50" y="120" font-family="Nunito,sans-serif" font-weight="700" font-size="11" fill="#192853" letter-spacing="1.5">ANNUAL MUSIC FESTIVAL</text>
                <text x="50" y="135" font-family="Nunito,sans-serif" font-size="9.5" fill="#192853" opacity=".7">July 12 · 2025 · 19:00 WIB</text>
                <rect x="50" y="150" width="2" height="28" rx="1" fill="#192853" opacity=".4" />
                <rect x="55" y="150" width="4" height="28" rx="1" fill="#192853" opacity=".4" />
                <rect x="62" y="150" width="2" height="28" rx="1" fill="#192853" opacity=".4" />
                <rect x="67" y="150" width="5" height="28" rx="1" fill="#192853" opacity=".4" />
                <rect x="75" y="150" width="2" height="28" rx="1" fill="#192853" opacity=".4" />
                <rect x="80" y="150" width="3" height="28" rx="1" fill="#192853" opacity=".4" />
                <rect x="86" y="150" width="2" height="28" rx="1" fill="#192853" opacity=".4" />
                <rect x="91" y="150" width="4" height="28" rx="1" fill="#192853" opacity=".4" />
                <rect x="98" y="150" width="2" height="28" rx="1" fill="#192853" opacity=".4" />
                <rect x="190" y="148" width="30" height="30" rx="4" fill="#192853" opacity=".15" />
                <rect x="194" y="152" width="8" height="8" rx="1.5" fill="#192853" opacity=".5" />
                <rect x="208" y="152" width="8" height="8" rx="1.5" fill="#192853" opacity=".5" />
                <rect x="194" y="166" width="8" height="8" rx="1.5" fill="#192853" opacity=".5" />
                <rect x="204" y="162" width="4" height="4" rx="1" fill="#192853" opacity=".4" />
                <rect x="210" y="168" width="8" height="4" rx="1" fill="#192853" opacity=".4" />

                <!-- Second ticket -->
                <g transform="rotate(-12,220,70)">
                    <rect x="140" y="30" width="130" height="58" rx="10" fill="#EFF8FF" opacity=".9" />
                    <circle cx="140" cy="59" r="8" fill="#192853" />
                    <circle cx="270" cy="59" r="8" fill="#192853" />
                    <text x="156" y="52" font-family="Nunito,sans-serif" font-weight="700" font-size="9" fill="#192853" letter-spacing="1">TECH CONFERENCE</text>
                    <text x="156" y="64" font-family="Nunito,sans-serif" font-size="8" fill="#192853" opacity=".6">VIP · Seat A-14</text>
                    <line x1="148" y1="59" x2="262" y2="59" stroke="#192853" stroke-width="1" stroke-dasharray="4 4" opacity=".2" />
                    <rect x="155" y="69" width="2" height="14" rx="1" fill="#192853" opacity=".3" />
                    <rect x="160" y="69" width="3" height="14" rx="1" fill="#192853" opacity=".3" />
                    <rect x="166" y="69" width="2" height="14" rx="1" fill="#192853" opacity=".3" />
                    <rect x="170" y="69" width="4" height="14" rx="1" fill="#192853" opacity=".3" />
                </g>

                <!-- Third ticket -->
                <g transform="rotate(8,30,220)">
                    <rect x="10" y="210" width="110" height="52" rx="9" fill="#192853" opacity=".85" />
                    <circle cx="10" cy="236" r="7" fill="#1a2c5e" />
                    <circle cx="120" cy="236" r="7" fill="#1a2c5e" />
                    <text x="24" y="230" font-family="Nunito,sans-serif" font-weight="700" font-size="8.5" fill="#FFE14E" letter-spacing="1">FOOD FESTIVAL</text>
                    <text x="24" y="242" font-family="Nunito,sans-serif" font-size="8" fill="rgba(255,255,255,.5)">Aug 20 · Stand C</text>
                    <line x1="17" y1="236" x2="113" y2="236" stroke="#FFE14E" stroke-width="1" stroke-dasharray="4 4" opacity=".25" />
                    <rect x="24" y="247" width="2" height="11" rx="1" fill="#FFE14E" opacity=".35" />
                    <rect x="28" y="247" width="3" height="11" rx="1" fill="#FFE14E" opacity=".35" />
                    <rect x="33" y="247" width="2" height="11" rx="1" fill="#FFE14E" opacity=".35" />
                    <rect x="38" y="247" width="4" height="11" rx="1" fill="#FFE14E" opacity=".35" />
                </g>

                <!-- Stars & sparkles -->
                <polygon points="30,50 33,44 36,50 42,50 37,54 39,61 33,57 27,61 29,54 24,50" fill="#FFE14E" opacity=".75" />
                <polygon points="218,80 220,76 222,80 226,80 223,82 224,86 220,84 216,86 217,82 214,80" fill="#FFE14E" opacity=".6" />
                <polygon points="235,220 236.5,217 238,220 241,220 238.5,221.5 239.5,225 236.5,223 233.5,225 234.5,221.5 232,220" fill="#FFE14E" opacity=".5" />
                <circle cx="195" cy="240" r="4" fill="#FFE14E" opacity=".5" />
                <circle cx="205" cy="248" r="2.5" fill="#FFE14E" opacity=".4" />
                <circle cx="58" cy="72" r="4" fill="#EFF8FF" opacity=".6" />
                <rect x="200" y="205" width="7" height="7" rx="2" fill="#FFE14E" opacity=".5" transform="rotate(20,203,208)" />
                <rect x="45" y="270" width="6" height="6" rx="2" fill="#EFF8FF" opacity=".4" transform="rotate(-15,48,273)" />

                <!-- Music note -->
                <g fill="#FFE14E" opacity=".55" transform="translate(200,55)">
                    <ellipse cx="5" cy="16" rx="5" ry="4" />
                    <rect x="9" y="0" width="2" height="16" />
                    <rect x="9" y="0" width="12" height="2" />
                    <rect x="19" y="0" width="2" height="8" />
                    <ellipse cx="15" cy="12" rx="5" ry="4" transform="translate(6,0)" />
                </g>
            </svg>
            @endverbatim

            <div class="left-label">
                <h2>Tiket &amp; Event Anda</h2>
                <p>Kelola semua tiket dan acara<br>favorit Anda di satu tempat.</p>
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="right">
            <h1>Login</h1>
            <p class="sub">Selamat datang kembali! Masuk ke akun Anda.</p>

            {{-- ALERT LARAVEL --}}
            @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="/login">
                @csrf

                <!-- Username -->
                <div class="field">
                    <label>Username</label>
                    <div class="inp-wrap">
                        <svg class="ico" viewBox="0 0 24 24">
                            <circle cx="12" cy="8" r="4" />
                            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                        </svg>
                        <input
                            type="text"
                            name="username"
                            value="{{ old('username') }}"
                            placeholder="Masukkan username Anda"
                            required>
                    </div>
                </div>

                <div class="field">
                    <label for="password">Password</label>

                    <div class="inp-wrap">

                        <!-- ICON KUNCI -->
                        <svg class="ico" viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>

                        <!-- CHECKBOX HIDDEN -->
                        <input type="checkbox" id="togglePass" hidden>

                        <!-- INPUT PASSWORD -->
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            required>

                        <!-- ICON MATA -->
                        <label for="togglePass" class="eye">
                            <!-- eye -->
                            <svg class="eye-open" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>

                            <!-- eye off -->
                            <svg class="eye-close" viewBox="0 0 24 24">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8" />
                                <line x1="1" y1="1" x2="23" y2="23" />
                            </svg>
                        </label>

                    </div>
                </div>

                <div class="options-row">
                    <a href="{{ route('password.forgot') }}" class="forgot">Lupa password?</a>
                </div>

                <button class="btn">
                    Log in <span class="acc">→</span>
                </button>
            </form>

            <p class="reg">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
        </div>

    </div>

    <script>
        function togglePass() {
            var input = document.getElementById('password');
            var icon = document.getElementById('eye-icon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<line x1="1" y1="1" x2="23" y2="23"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<circle cx="12" cy="12" r="3"/>';
            }
        }
    </script>

</body>

</html>