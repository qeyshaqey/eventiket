<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenis Tiket - Eventiket</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            color: white;
            font-size: 36px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .header p {
            color: rgba(255,255,255,0.8);
            margin-top: 8px;
            font-size: 16px;
        }

        .cards {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .card {
            background: white;
            border-radius: 20px;
            padding: 30px 25px;
            width: 260px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card.vip {
            border-top: 6px solid #f6c90e;
        }

        .card.regular {
            border-top: 6px solid #4CAF50;
        }

        .card.earlybird {
            border-top: 6px solid #2196F3;
        }

        .badge {
            display: inline-block;
            padding: 5px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .vip .badge {
            background: #fff8e1;
            color: #f6c90e;
        }

        .regular .badge {
            background: #e8f5e9;
            color: #4CAF50;
        }

        .earlybird .badge {
            background: #e3f2fd;
            color: #2196F3;
        }

        .icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .card h2 {
            font-size: 22px;
            color: #333;
            margin-bottom: 10px;
        }

        .price {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin: 15px 0;
        }

        .price span {
            font-size: 14px;
            color: #999;
            font-weight: 400;
        }

        .desc {
            color: #777;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .btn {
            display: block;
            padding: 12px;
            border-radius: 10px;
            border: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .btn:hover {
            opacity: 0.85;
        }

        .vip .btn {
            background: #f6c90e;
            color: white;
        }

        .regular .btn {
            background: #4CAF50;
            color: white;
        }

        .earlybird .btn {
            background: #2196F3;
            color: white;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            color: rgba(255,255,255,0.7);
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1> Eventix</h1>
            <p>Pilih jenis tiket yang sesuai dengan kebutuhanmu</p>
        </div>

        <div class="cards">
            <!-- VIP -->
            <div class="card vip">
                <div class="badge">⭐ EKSKLUSIF</div>
                <div class="icon">👑</div>
                <h2>VIP</h2>
                <p class="desc">Kursi terbaik dengan akses dan layanan premium</p>
                <div class="price">Rp 200.000 <span>/orang</span></div>
                <a href="#" class="btn">Beli Sekarang</a>
            </div>

            <!-- Regular -->
            <div class="card regular">
                <div class="badge">✅ POPULER</div>
                <div class="icon">🎫</div>
                <h2>Regular</h2>
                <p class="desc">Kursi standar dengan kenyamanan yang terjamin</p>
                <div class="price">Rp 150.000 <span>/orang</span></div>
                <a href="#" class="btn">Beli Sekarang</a>
            </div>

            <!-- Early Bird -->
            <div class="card earlybird">
                <div class="badge">🔥 TERBATAS</div>
                <div class="icon">🐦</div>
                <h2>Early Bird</h2>
                <p class="desc">Harga spesial untuk pembelian awal, stok terbatas!</p>
                <div class="price">Rp 100.000 <span>/orang</span></div>
                <a href="#" class="btn">Beli Sekarang</a>
            </div>
        </div>

        <div class="footer">
            <p>© 2026 Eventiket. All rights reserved.</p>
        </div>
    </div>
</body>
</html>