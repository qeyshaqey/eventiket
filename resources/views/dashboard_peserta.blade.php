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

    </style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="logo">Eventiket</div>

    <div class="nav-right">
        <a href="/home">Home</a>
        <a href="/event">Event</a>
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

<!--FOOTER -->
<footer>
    <p>© 2026 Eventiket</p>
</footer>

</body>
</html>