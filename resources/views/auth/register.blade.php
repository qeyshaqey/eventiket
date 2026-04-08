<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Daftar — Tiket &amp; Event</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,700&family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet" />
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body{min-height:100vh;display:flex;align-items:center;justify-content:center;background:#e8ecf5;font-family:'DM Sans',sans-serif}
        .wrap{display:flex;width:900px;max-width:95vw;min-height:520px;border-radius:24px;overflow:hidden;box-shadow:0 32px 80px rgba(25,40,83,.18),0 8px 24px rgba(25,40,83,.10)}
        .left{flex:0 0 46%;background:#192853;position:relative;overflow:hidden;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:32px 24px}
        .blob-top{position:absolute;top:-60px;right:-60px;width:200px;height:200px;background:#FFE14E;border-radius:50%;opacity:.12}
        .blob-bot{position:absolute;bottom:-80px;left:-40px;width:220px;height:220px;background:#FFE14E;border-radius:50%;opacity:.08}
        .left svg{position:relative;z-index:2}
        .left-label{position:relative;z-index:2;margin-top:20px;text-align:center}
        .left-label h2{font-family:'Playfair Display',serif;font-style:italic;font-size:22px;color:#FFE14E;margin-bottom:6px}
        .left-label p{font-size:13px;color:rgba(255,255,255,.55);line-height:1.6}
        .right{flex:1;background:#fff;padding:36px 40px;display:flex;flex-direction:column;justify-content:center}
        .right h1{font-size:26px;font-weight:700;color:#192853;text-align:center;margin-bottom:4px}
        .right .subtitle{text-align:center;font-size:13px;color:#8a96b0;margin-bottom:28px}
        .success-banner{background:#e8f9f0;border:1px solid #7dd9aa;border-radius:9px;padding:11px 14px;color:#1a7a4a;font-size:13px;margin-bottom:16px;display:flex;align-items:center;gap:9px}
        .form-row{display:flex;gap:13px}
        .form-group{display:flex;flex-direction:column;margin-bottom:13px;flex:1}
        .form-group label{font-size:11px;font-weight:600;color:#1a2340;letter-spacing:.6px;text-transform:uppercase;margin-bottom:4px}
        .input-wrap{position:relative}
        .input-wrap input{width:100%;padding:10px 40px 10px 13px;border:1.5px solid #dde3f0;border-radius:9px;font-size:13.5px;font-family:'DM Sans',sans-serif;color:#1a2340;background:#f4f6fb;outline:none;transition:border .17s,box-shadow .17s,background .17s}
        .input-wrap input::placeholder{color:#b0b8cc}
        .input-wrap input:focus{border-color:#f5c800;box-shadow:0 0 0 3px rgba(245,200,0,.15);background:#fff}
        .input-wrap input.err{border-color:#e5414a;box-shadow:0 0 0 3px rgba(229,65,74,.10)}
        .toggle-pw{position:absolute;right:11px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#9aabb5;display:flex;align-items:center;padding:0}
        .toggle-pw:hover{color:#1a2340}
        .field-error{font-size:11px;color:#e5414a;margin-top:3px}
        .strength-bar{display:flex;gap:4px;margin-top:5px}
        .strength-bar span{flex:1;height:3px;border-radius:3px;background:#dde3f0;transition:background .3s}
        .strength-label{font-size:10.5px;color:#7a84a0;margin-top:3px}
        .btn-submit{width:100%;padding:14px;background:#192853;color:#fff;border:none;border-radius:12px;font-family:'DM Sans',sans-serif;font-size:15px;font-weight:700;cursor:pointer;position:relative;overflow:hidden;transition:transform .15s,box-shadow .2s,background .2s;margin-top:4px;display:inline-flex;align-items:center;justify-content:center;gap:8px}
        .btn-submit::before{content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,225,78,.15),transparent);transition:left .5s}
        .btn-submit:hover::before{left:100%}
        .btn-submit:hover{background:#243a70;transform:translateY(-1px);box-shadow:0 8px 24px rgba(25,40,83,.28)}
        .login-link{text-align:center;margin-top:15px;font-size:13px;color:#7a84a0}
        .login-link a{color:#1a2340;font-weight:600;text-decoration:none}
        .login-link a:hover{text-decoration:underline}
        @media(max-width:680px){.wrap{flex-direction:column}.left{width:100%;min-height:210px}.right{padding:24px 20px}.form-row{flex-direction:column;gap:0}}
    </style>
</head>

<body>
<div class="wrap">

    {{-- ═══ Left Panel ═══ --}}
    <div class="left">
        <div class="blob-top"></div>
        <div class="blob-bot"></div>

        <svg width="260" height="300" viewBox="0 0 260 300" xmlns="http://www.w3.org/2000/svg">
            <circle cx="130" cy="150" r="110" fill="#FFE14E" opacity=".05"/>
            <circle cx="130" cy="150" r="80"  fill="#FFE14E" opacity=".05"/>
            <rect x="20" y="90" width="220" height="100" rx="14" fill="#FFE14E"/>
            <circle cx="20"  cy="140" r="12" fill="#192853"/>
            <circle cx="240" cy="140" r="12" fill="#192853"/>
            <line x1="32" y1="140" x2="228" y2="140" stroke="#192853" stroke-width="1.5" stroke-dasharray="6 5" opacity=".3"/>
            <text x="50" y="120" font-family="Nunito,sans-serif" font-weight="700" font-size="11" fill="#192853" letter-spacing="1.5">ANNUAL MUSIC FESTIVAL</text>
            <text x="50" y="135" font-family="Nunito,sans-serif" font-size="9.5" fill="#192853" opacity=".7">July 12 · 2025 · 19:00 WIB</text>
            <rect x="50"  y="150" width="2" height="28" rx="1" fill="#192853" opacity=".4"/>
            <rect x="55"  y="150" width="4" height="28" rx="1" fill="#192853" opacity=".4"/>
            <rect x="62"  y="150" width="2" height="28" rx="1" fill="#192853" opacity=".4"/>
            <rect x="67"  y="150" width="5" height="28" rx="1" fill="#192853" opacity=".4"/>
            <rect x="75"  y="150" width="2" height="28" rx="1" fill="#192853" opacity=".4"/>
            <rect x="80"  y="150" width="3" height="28" rx="1" fill="#192853" opacity=".4"/>
            <rect x="86"  y="150" width="2" height="28" rx="1" fill="#192853" opacity=".4"/>
            <rect x="91"  y="150" width="4" height="28" rx="1" fill="#192853" opacity=".4"/>
            <rect x="98"  y="150" width="2" height="28" rx="1" fill="#192853" opacity=".4"/>
            <rect x="190" y="148" width="30" height="30" rx="4" fill="#192853" opacity=".15"/>
            <rect x="194" y="152" width="8"  height="8"  rx="1.5" fill="#192853" opacity=".5"/>
            <rect x="208" y="152" width="8"  height="8"  rx="1.5" fill="#192853" opacity=".5"/>
            <rect x="194" y="166" width="8"  height="8"  rx="1.5" fill="#192853" opacity=".5"/>
            <rect x="204" y="162" width="4"  height="4"  rx="1"   fill="#192853" opacity=".4"/>
            <rect x="210" y="168" width="8"  height="4"  rx="1"   fill="#192853" opacity=".4"/>
            <g transform="rotate(-12,220,70)">
                <rect x="140" y="30" width="130" height="58" rx="10" fill="#EFF8FF" opacity=".9"/>
                <circle cx="140" cy="59" r="8" fill="#192853"/>
                <circle cx="270" cy="59" r="8" fill="#192853"/>
                <text x="156" y="52" font-family="Nunito,sans-serif" font-weight="700" font-size="9" fill="#192853" letter-spacing="1">TECH CONFERENCE</text>
                <text x="156" y="64" font-family="Nunito,sans-serif" font-size="8" fill="#192853" opacity=".6">VIP · Seat A-14</text>
                <line x1="148" y1="59" x2="262" y2="59" stroke="#192853" stroke-width="1" stroke-dasharray="4 4" opacity=".2"/>
                <rect x="155" y="69" width="2" height="14" rx="1" fill="#192853" opacity=".3"/>
                <rect x="160" y="69" width="3" height="14" rx="1" fill="#192853" opacity=".3"/>
                <rect x="166" y="69" width="2" height="14" rx="1" fill="#192853" opacity=".3"/>
                <rect x="170" y="69" width="4" height="14" rx="1" fill="#192853" opacity=".3"/>
            </g>
            <g transform="rotate(8,30,220)">
                <rect x="10"  y="210" width="110" height="52" rx="9" fill="#192853" opacity=".85"/>
                <circle cx="10"  cy="236" r="7" fill="#1a2c5e"/>
                <circle cx="120" cy="236" r="7" fill="#1a2c5e"/>
                <text x="24" y="230" font-family="Nunito,sans-serif" font-weight="700" font-size="8.5" fill="#FFE14E" letter-spacing="1">FOOD FESTIVAL</text>
                <text x="24" y="242" font-family="Nunito,sans-serif" font-size="8" fill="rgba(255,255,255,.5)">Aug 20 · Stand C</text>
                <line x1="17" y1="236" x2="113" y2="236" stroke="#FFE14E" stroke-width="1" stroke-dasharray="4 4" opacity=".25"/>
                <rect x="24" y="247" width="2" height="11" rx="1" fill="#FFE14E" opacity=".35"/>
                <rect x="28" y="247" width="3" height="11" rx="1" fill="#FFE14E" opacity=".35"/>
                <rect x="33" y="247" width="2" height="11" rx="1" fill="#FFE14E" opacity=".35"/>
                <rect x="38" y="247" width="4" height="11" rx="1" fill="#FFE14E" opacity=".35"/>
            </g>
            <polygon points="30,50 33,44 36,50 42,50 37,54 39,61 33,57 27,61 29,54 24,50" fill="#FFE14E" opacity=".75"/>
            <polygon points="218,80 220,76 222,80 226,80 223,82 224,86 220,84 216,86 217,82 214,80" fill="#FFE14E" opacity=".6"/>
            <polygon points="235,220 236.5,217 238,220 241,220 238.5,221.5 239.5,225 236.5,223 233.5,225 234.5,221.5 232,220" fill="#FFE14E" opacity=".5"/>
            <circle cx="195" cy="240" r="4"   fill="#FFE14E" opacity=".5"/>
            <circle cx="205" cy="248" r="2.5" fill="#FFE14E" opacity=".4"/>
            <circle cx="58"  cy="72"  r="4"   fill="#EFF8FF" opacity=".6"/>
            <rect x="200" y="205" width="7" height="7" rx="2" fill="#FFE14E" opacity=".5" transform="rotate(20,203,208)"/>
            <rect x="45"  y="270" width="6" height="6" rx="2" fill="#EFF8FF" opacity=".4" transform="rotate(-15,48,273)"/>
            <g fill="#FFE14E" opacity=".55" transform="translate(200,55)">
                <ellipse cx="5" cy="16" rx="5" ry="4"/>
                <rect x="9" y="0" width="2" height="16"/>
                <rect x="9" y="0" width="12" height="2"/>
                <rect x="19" y="0" width="2" height="8"/>
                <ellipse cx="15" cy="12" rx="5" ry="4" transform="translate(6,0)"/>
            </g>
        </svg>

        <div class="left-label">
            <h2>Tiket &amp; Event Anda</h2>
            <p>Kelola semua tiket dan acara<br>favorit Anda di satu tempat.</p>
        </div>
    </div>
    {{-- ═══ END LEFT ═══ --}}

    {{-- ═══ Right Panel ═══ --}}
    <div class="right">
        <h1>Daftar</h1>
        <p class="subtitle">Buat akun baru dan mulai kelola tiket Anda.</p>

        {{-- Success Banner --}}
        @if (session('success'))
            <div class="success-banner">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" fill="#7dd9aa"/>
                    <path d="M8 12.5l3 3 5-5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Akun berhasil dibuat! Silakan
                <a href="{{ route('login') }}" style="color:#1a7a4a;font-weight:600;margin-left:3px">login sekarang</a>.
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('register.store') }}" novalidate>
            @csrf

            {{-- Username --}}
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrap">
                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="nama_pengguna"
                        value="{{ old('username') }}"
                        class="{{ $errors->has('username') ? 'err' : '' }}"
                        autocomplete="username"
                    />
                </div>
                @error('username')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrap">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="contoh@email.com"
                        value="{{ old('email') }}"
                        class="{{ $errors->has('email') ? 'err' : '' }}"
                        autocomplete="email"
                    />
                </div>
                @error('email')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Password + Confirm Password --}}
            <div class="form-row">

                {{-- Password --}}
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            class="{{ $errors->has('password') ? 'err' : '' }}"
                            autocomplete="new-password"
                            oninput="checkStrength(this.value)"
                        />
                        <button type="button" class="toggle-pw" onclick="togglePw('password')" aria-label="Tampilkan">
                            <svg id="ico-password" width="17" height="17" fill="none" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z" stroke="currentColor" stroke-width="2"/>
                                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </button>
                    </div>
                    {{-- Strength Bar --}}
                    <div class="strength-bar">
                        <span id="sb1"></span>
                        <span id="sb2"></span>
                        <span id="sb3"></span>
                        <span id="sb4"></span>
                    </div>
                    <div class="strength-label" id="slbl"></div>
                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="form-group">
                    <label for="confirm_password">Konfirmasi Password</label>
                    <div class="input-wrap">
                        <input
                            type="password"
                            id="confirm_password"
                            name="confirm_password"
                            placeholder="••••••••"
                            class="{{ $errors->has('confirm_password') ? 'err' : '' }}"
                            autocomplete="new-password"
                        />
                        <button type="button" class="toggle-pw" onclick="togglePw('confirm_password')" aria-label="Tampilkan">
                            <svg id="ico-confirm_password" width="17" height="17" fill="none" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z" stroke="currentColor" stroke-width="2"/>
                                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </button>
                    </div>
                    @error('confirm_password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

            </div>
            {{-- END form-row --}}

            <button type="submit" class="btn-submit">
                Buat Akun
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                    <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </form>

        <p class="login-link">Sudah punya akun? <a href="{{ route('login') }}">Masuk sekarang</a></p>
    </div>
    {{-- ═══ END RIGHT ═══ --}}

</div>

<script>
    function togglePw(id) {
        const inp = document.getElementById(id);
        const ico = document.getElementById('ico-' + id);
        const show = inp.type === 'password';
        inp.type = show ? 'text' : 'password';
        ico.innerHTML = show
            ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24M1 1l22 22" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>'
            : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>';
    }

    function checkStrength(pw) {
        const bars = [1, 2, 3, 4].map(n => document.getElementById('sb' + n));
        const lbl  = document.getElementById('slbl');
        const cols = ['#e5414a', '#f5a623', '#f5c800', '#2ecc71'];
        const lbls = ['Sangat Lemah', 'Lemah', 'Cukup Kuat', 'Kuat'];
        let score = 0;
        if (pw.length >= 8)          score++;
        if (/[A-Z]/.test(pw))        score++;
        if (/[0-9]/.test(pw))        score++;
        if (/[^A-Za-z0-9]/.test(pw)) score++;
        bars.forEach((b, i) => b.style.background = i < score ? cols[score - 1] : '#dde3f0');
        lbl.textContent = pw.length ? (lbls[score - 1] ?? lbls[3]) : '';
        lbl.style.color = pw.length ? cols[score - 1] : '#7a84a0';
    }
</script>
</body>
</html>