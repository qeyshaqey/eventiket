<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Reset Password</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #EFF8FF;
            font-family: 'Arial', sans-serif;
        }
        .wrapper {
            max-width: 560px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(25, 40, 83, 0.12);
        }
        .header {
            background-color: #192853;
            padding: 32px 40px;
            text-align: center;
        }
        .header h1 {
            color: #FFE14E;
            font-size: 22px;
            margin: 0 0 4px 0;
            letter-spacing: 1px;
        }
        .header p {
            color: rgba(255,255,255,0.6);
            font-size: 13px;
            margin: 0;
        }
        .body {
            padding: 36px 40px;
        }
        .body p {
            color: #4a5568;
            font-size: 15px;
            line-height: 1.7;
            margin: 0 0 16px 0;
        }
        .otp-box {
            background: #EFF8FF;
            border: 2px dashed #192853;
            border-radius: 14px;
            text-align: center;
            padding: 24px 16px;
            margin: 24px 0;
        }
        .otp-box .label {
            font-size: 12px;
            color: #8a96b0;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 8px;
        }
        .otp-box .code {
            font-size: 42px;
            font-weight: 700;
            color: #192853;
            letter-spacing: 10px;
        }
        .otp-box .expiry {
            font-size: 12px;
            color: #e53e3e;
            margin-top: 10px;
        }
        .warning {
            background: #fff8e1;
            border-left: 4px solid #FFE14E;
            border-radius: 6px;
            padding: 12px 16px;
            font-size: 13px;
            color: #744210;
        }
        .footer {
            background: #f8fafc;
            padding: 20px 40px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        .footer p {
            font-size: 12px;
            color: #a0aec0;
            margin: 0;
        }
        .footer strong {
            color: #192853;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Header -->
        <div class="header">
            <h1>🎟 EventiX</h1>
            <p>Permintaan Reset Password</p>
        </div>

        <!-- Body -->
        <div class="body">
            <p>Halo,</p>
            <p>Kami menerima permintaan untuk mereset password akun EventiX Anda. Gunakan kode OTP berikut untuk melanjutkan proses verifikasi:</p>

            <!-- OTP Code Box -->
            <div class="otp-box">
                <div class="label">Kode OTP Anda</div>
                <div class="code">{{ $otp }}</div>
                <div class="expiry">⏱ Kode ini berlaku selama <strong>10 menit</strong></div>
            </div>

            <div class="warning">
                ⚠️ <strong>Jangan bagikan kode ini kepada siapapun.</strong> Tim EventiX tidak akan pernah meminta kode OTP Anda.
            </div>

            <p style="margin-top: 20px;">Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini. Password Anda tidak akan berubah.</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh <strong>EventiX</strong>. Mohon jangan membalas email ini.</p>
        </div>
    </div>
</body>
</html>
