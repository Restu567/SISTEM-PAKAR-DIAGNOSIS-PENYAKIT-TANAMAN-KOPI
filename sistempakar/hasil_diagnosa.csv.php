<?php
session_start();

/* =========================
   RESET DIAGNOSA
   ========================= */
if (isset($_POST['reset'])) {
    $_SESSION['node'] = "G37";
    $_SESSION['sudah_simpan'] = false;
    header("Location: diagnosa_tree.php");
    exit;
}

/* =========================
   INISIALISASI SESSION
   ========================= */
if (!isset($_SESSION['node'])) $_SESSION['node'] = "G37";
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
    }
}

/* =========================
   SIMPAN KE CSV (EXCEL)
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
?>

<!DOCTYPE html>
<html>
<head>
<title>Diagnosa Tanaman Kopi</title>
<style>
body{font-family:Arial;background:#eef;}
.box{background:white;width:500px;margin:50px auto;padding:25px;border-radius:10px;text-align:center;}
button,a{padding:10px 20px;margin:10px;color:white;border:none;text-decoration:none;display:inline-block;}
.ya{background:green;}
.tidak{background:red;}
.reset{background:gray;}
.dashboard{background:#2c7a2c;}
.excel{background:#1d6f42;}
.pdf{background:#8b0000;}
</style>
</head>

<body>
<div class="box">

<?php
$node = $_SESSION['node'];

if (strpos($node, "P") === 0) {
    echo "<h2>HASIL DIAGNOSA</h2>";
    echo "<h3>".$penyakit[$node]."</h3>";

    echo "
    <form method='post'>
        <button class='reset' name='reset'>Diagnosa Ulang</button>
    </form>

    <a href='hasil_diagnosa.csv' class='excel' target='_blank'>📊 File Excel</a>
    <a href='cetak_pdf.php' class='pdf' target='_blank'>🖨 Cetak PDF</a>
    <br><br>
    <a href='dashboard.php' class='dashboard'>⬅ Dashboard</a>
    ";
} else {
    echo "<h2>".$gejala[$node]."</h2>";
    echo "
    <form method='post'>
        <button class='ya' name='jawab' value='ya'>YA</button>
        <button class='tidak' name='jawab' value='tidak'>TIDAK</button>
    </form>
    <a href='dashboard.php' class='dashboard'>⬅ Dashboard</a>
    ";
}
?>

</div>
</body>
</html>
