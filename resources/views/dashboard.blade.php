<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Eventiket</title>

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
            background:#2c3e50;
            padding:15px 40px;
            color:white;
        }

        .logo{
            font-size:22px;
            font-weight:bold;
        }

        .nav-right a{
            text-decoration:none;
            color:white;
            margin-left:15px;
            padding:8px 14px;
            border-radius:6px;
        }

        .login{
            background:#3498db;
        }

        .signup{
            background:#2ecc71;
        }

        .nav-right a:hover{
            opacity:0.9;
        }

        /* HERO / IKLAN */

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

        .hero button{
            margin-top:20px;
            padding:12px 25px;
            border:none;
            background:#e74c3c;
            color:white;
            font-size:16px;
            border-radius:8px;
            cursor:pointer;
        }

        .hero button:hover{
            background:#c0392b;
        }

        /* CONTAINER */

        .container{
            padding:40px;
        }

        .card{
            background:white;
            padding:25px;
            border-radius:10px;
            box-shadow:0 3px 8px rgba(0,0,0,0.1);
            margin-bottom:20px;
        }

        .menu{
            display:grid;
            grid-template-columns: repeat(auto-fit, minmax(200px,1fr));
            gap:25px;
            margin-top:20px;
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

        .icon{
            font-size:40px;
            margin-bottom:10px;
        }

        .title{
            font-size:18px;
            font-weight:bold;
        }
</style>
</head>

<body>
<!-- NAVBAR -->

<div class="navbar">

    <div class="logo">
        Eventiket
    </div>

    <div class="nav-right">
        <a class="login" href="#">Login</a>
        <a class="signup" href="#">Sign Up</a>
    </div>

</div>

<!-- HERO IKLAN EVENT -->

<div class="hero">

    <h1>Temukan Event Terbaik</h1>
    <p>Konser, Seminar, Festival, dan banyak lagi!</p>

    <button>Lihat Event</button>

</div>


<!-- MENU DASHBOARD -->

<div class="menu">

    <a class="menu-card" href="/list_event">
        <div class="title">List Event</div>
        <p>Lihat semua event yang tersedia</p>
    </a>

    <a class="menu-card" href="/jenis_tiket">
        <div class="title">Jenis Tiket</div>
        <p>Kelola kategori tiket event</p>
    </a>
    </div>

</div>

</body>
</html>