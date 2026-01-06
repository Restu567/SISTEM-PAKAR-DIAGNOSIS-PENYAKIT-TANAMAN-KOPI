<?php
session_start();

/* =========================
   RESET DIAGNOSA
   ========================= */
if (isset($_POST['reset'])) {
    $_SESSION['node'] = "G37";
    $_SESSION['step'] = 1;
    $_SESSION['sudah_simpan'] = false;
    header("Location: diagnosa_tree.php");
    exit;
}

/* =========================
   INISIALISASI SESSION
   ========================= */
if (!isset($_SESSION['node'])) $_SESSION['node'] = "G37";
if (!isset($_SESSION['step'])) $_SESSION['step'] = 1;
if (!isset($_SESSION['sudah_simpan'])) $_SESSION['sudah_simpan'] = false;

/* =========================
   DATA GEJALA
   ========================= */
$gejala = [
    "G37"=>"Apakah buah kopi rontok?",
    "G45"=>"Apakah terdapat lubang pada ujung buah?",
    "G13"=>"Apakah kulit buah mengering dan keras?",
    "G30"=>"Apakah terdapat bintil kecil merah pada kayu?",
    "G36"=>"Apakah daun berguguran?",
    "G47"=>"Apakah terdapat cacat pada buah muda?",
    "G15"=>"Apakah daun memiliki bercak-bercak bulat?",
    "G49"=>"Apakah bercak dikelilingi halo kuning?",
    "G48"=>"Apakah terdapat serbuk jingga di balik daun?",
    "G28"=>"Apakah pusat bercak berwarna putih keabu-abuan?",
    "G50"=>"Apakah terdapat bercak hitam pada daun?"
];

/* =========================
   DATA PENYAKIT
   ========================= */
$penyakit = [
    "P01"=>"Karat Daun",
    "P03"=>"Bercak Daun",
    "P11"=>"Hama Kutu Dompolan",
    "P14"=>"Hama Pengerek Buah"
];

/* =========================
   POHON KEPUTUSAN
   ========================= */
$tree = [
    "G37"=>["ya"=>"G45","tidak"=>"G15"],
    "G45"=>["ya"=>"G13","tidak"=>"G36"],
    "G13"=>["ya"=>"G30","tidak"=>"P11"],
    "G30"=>["ya"=>"P14","tidak"=>"P11"],
    "G36"=>["ya"=>"G47","tidak"=>"P11"],
    "G47"=>["ya"=>"P11","tidak"=>"P11"],
    "G15"=>["ya"=>"G49","tidak"=>"P03"],
    "G49"=>["ya"=>"G48","tidak"=>"G28"],
    "G48"=>["ya"=>"P01","tidak"=>"P03"],
    "G28"=>["ya"=>"G50","tidak"=>"P03"],
    "G50"=>["ya"=>"P03","tidak"=>"P03"]
];

/* =========================
   PROSES JAWABAN
   ========================= */
if (isset($_POST['jawab'])) {
    $node = $_SESSION['node'];
    if (isset($tree[$node][$_POST['jawab']])) {
        $_SESSION['node'] = $tree[$node][$_POST['jawab']];
        $_SESSION['step']++;
    }
}

/* =========================
   SIMPAN KE EXCEL (CSV)
   ========================= */
if (strpos($_SESSION['node'], "P") === 0 && $_SESSION['sudah_simpan'] == false) {

    $file = "hasil_diagnosa.csv";
    if (!file_exists($file)) {
        file_put_contents($file, "Tanggal,Jam,Hasil Diagnosa\n");
    }

    $data = date("Y-m-d").",".date("H:i:s").",".$penyakit[$_SESSION['node']]."\n";
    file_put_contents($file, $data, FILE_APPEND);

    $_SESSION['sudah_simpan'] = true;
}

/* =========================
   PROGRESS BAR
   ========================= */
$totalStep = 6;
$progress = min(100, ($_SESSION['step'] / $totalStep) * 100);
if (strpos($_SESSION['node'], "P") === 0) $progress = 100;
?>

<!DOCTYPE html>
<html>
<head>
<title>Diagnosa Tanaman Kopi</title>
<style>
body{
    font-family:'Segoe UI',Arial;
    background:linear-gradient(120deg,#a8e063,#56ab2f);
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
}
.container{
    background:#fff;
    width:520px;
    padding:30px;
    border-radius:15px;
    box-shadow:0 15px 30px rgba(0,0,0,0.2);
    text-align:center;
}
h2{color:#2f7a2f;}
.question{font-size:18px;margin:20px 0;}
button,a{
    padding:12px 22px;
    margin:6px;
    border-radius:30px;
    border:none;
    color:#fff;
    text-decoration:none;
    cursor:pointer;
    display:inline-block;
}
.btn-yes{background:#2ecc71;}
.btn-no{background:#e74c3c;}
.btn-reset{background:#7f8c8d;}
.btn-dashboard{background:#27ae60;}
.btn-excel{background:#1d6f42;}
.btn-pdf{background:#8b0000;}

.progress-box{margin-bottom:25px;}
.progress-text{font-size:14px;color:#555;margin-bottom:6px;}
.progress-bar{
    width:100%;
    height:12px;
    background:#e0e0e0;
    border-radius:20px;
    overflow:hidden;
}
.progress-fill{
    height:100%;
    width:<?php echo $progress; ?>%;
    background:linear-gradient(90deg,#56ab2f,#2ecc71);
    transition:0.4s;
}
.footer{margin-top:20px;font-size:12px;color:#888;}
</style>
</head>

<body>
<div class="container">

<div class="progress-box">
    <div class="progress-text">
        Langkah Diagnosa: <?php echo $_SESSION['step']; ?> / <?php echo $totalStep; ?>
    </div>
    <div class="progress-bar">
        <div class="progress-fill"></div>
    </div>
</div>

<?php
$node = $_SESSION['node'];

if (strpos($node, "P") === 0) {
    echo "<h2>✅ Hasil Diagnosa</h2>";
    echo "<h3>🌱 ".$penyakit[$node]."</h3>";

    echo "
    <form method='post'>
        <button class='btn-reset' name='reset'>🔄 Diagnosa Ulang</button>
    </form>

    <a href='hasil_diagnosa.csv' class='btn-excel' target='_blank'>📊 File Excel</a>
    <a href='cetak_pdf.php' class='btn-pdf' target='_blank'>🖨 Cetak PDF</a>
    <br><br>
    <a href='dashboard.php' class='btn-dashboard'>⬅ Dashboard</a>
    ";
} else {
    echo "<h2>🩺 Diagnosa Tanaman Kopi</h2>";
    echo "<div class='question'>".$gejala[$node]."</div>";
    echo "
    <form method='post'>
        <button class='btn-yes' name='jawab' value='ya'>✔ Ya</button>
        <button class='btn-no' name='jawab' value='tidak'>✖ Tidak</button>
    </form>
    <a href='dashboard.php' class='btn-dashboard'>⬅ Dashboard</a>
    ";
}
?>

<div class="footer">
    Sistem Pakar Diagnosa Tanaman Kopi © 2025
</div>

</div>
</body>
</html>
