<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Sistem Pakar Kopi</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f9;
        }
        .header {
            background: #2c7a2c;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            padding: 30px;
        }
        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            width: 300px;
            display: inline-block;
            margin: 15px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            vertical-align: top;
        }
        .card h3 {
            margin-top: 0;
            color: #2c3e50;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #2c7a2c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #777;
        }
    </style>
</head>

<body>

<div class="header">
    <h1>SISTEM PAKAR TANAMAN KOPI</h1>
    <p>Diagnosis Penyakit dan Hama Menggunakan Forward Chaining</p>
</div>

<div class="container">

    <div class="card">
        <h3>📌 Tentang Sistem</h3>
        <p>
            Sistem pakar ini digunakan untuk mendiagnosis penyakit dan hama
            pada tanaman kopi berdasarkan gejala yang dialami tanaman.
        </p>
    </div>

    <div class="card">
        <h3>🧠 Metode</h3>
        <p>
            Sistem menggunakan metode <b>Forward Chaining</b> dengan basis aturan
            (rule-based) untuk menentukan diagnosis penyakit tanaman kopi.
        </p>
    </div>

    <div class="card">
        <h3>🌱 Mulai Diagnosa</h3>
        <p>
            Klik tombol di bawah untuk memulai proses diagnosa
            berdasarkan gejala tanaman kopi.
        </p>
        <a href="diagnosa_tree.php" class="btn">Mulai Diagnosa</a>
    </div>

</div>

<div class="footer">
    <p>© 2025 | Sistem Pakar Diagnosis Tanaman Kopi</p>
</div>

</body>
</html>
