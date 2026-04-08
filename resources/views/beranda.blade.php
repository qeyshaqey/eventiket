<!DOCTYPE html>
<html>
<head>
    <title>Beranda Panitia</title>
    <style>
        body{
            margin:0;
            font-family: Arial;
            background:#f4f6f9;
        }

        .wrapper{
            display:flex;
        }

        /* SIDEBAR */
        .sidebar{
            width:220px;
            background:#2c3e50;
            color:white;
            min-height:100vh;
            padding:20px;
        }

        .sidebar h2{
            margin-bottom:20px;
        }

        .menu a{
            display:block;
            color:white;
            text-decoration:none;
            padding:20px;
            border-radius:10px;
            margin-bottom:10px;
            font-weight: bold;
        }

        .menu a.active,
        .menu a:hover{
            background: #fda50f;
        }

        /* CONTENT */
        .content{
            flex:1;
        }

        .navbar{
            background:#2c3e50;
            color:white;
            padding:15px;
            font-size:18px;
        }

        .container{
            padding:20px;
        }

        .cards{
            display:grid;
            grid-template-columns: repeat(4,1fr);
            gap:20px;
        }

        .card{
            background:white;
            padding:20px;
            border-radius:10px;
            box-shadow:0 4px 8px rgba(0,0,0,0.1);
        }

        .card h3{
            margin:0;
            color:#555;
        }

        .card h1{
            margin-top:10px;
        }

        .table{
            margin-top:30px;
            background:white;
            padding:20px;
            border-radius:10px;
        }

        table{
            width:100%;
            border-collapse: collapse;
        }

        th, td{
            text-align: center;
            padding:10px;
            border-bottom:1px solid #ddd;
        }

        .btn{
            padding:5px 10px;
            background:#3498db;
            color:white;
            border:none;
            border-radius:5px;
        }
    </style>
</head>
<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Panitia</h2>

        <div class="menu">
            <a href="{{ route('beranda.panitia') }}" class="active">Beranda</a>
            <a href="#">Event</a>
            <a href="#">Tiket</a>
            <a href="#">Peserta</a>
            <a href="#">Profil</a>

        </div>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <div class="navbar">
        </div>

        <div class="container">

            <!-- CARD -->
            <div class="cards">
                <div class="card">
                    <h3>Total Event</h3>
                    <h1>{{ $totalEvent }}</h1>
                </div>

                <div class="card">
                    <h3>Total Peserta</h3>
                    <h1>{{ $totalPeserta }}</h1>
                </div>

                <div class="card">
                    <h3>Total Tiket</h3>
                    <h1>{{ $totalTiket }}</h1>
                </div>

                <div class="card">
                    <h3>Event Aktif</h3>
                    <h1>{{ $eventAktif }}</h1>
                </div>
            </div>

            <!-- TABLE -->
            <div class="table">
                <h3>Daftar Event</h3>
                <table>
                    <tr>
                        <th>Nama Event</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>

                    @foreach($events as $event)
                    <tr>
                        <td>{{ $event['nama'] }}</td>
                        <td>{{ $event['tanggal'] }}</td>
                        <td>{{ $event['status'] }}</td>
                        <td><button class="btn">Detail</button></td>
                    </tr>
                    @endforeach

                </table>
            </div>

        </div>

    </div>

</div>

</body>
</html>