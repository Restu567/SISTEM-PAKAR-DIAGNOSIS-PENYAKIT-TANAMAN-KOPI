<?php
session_start();

if (!isset($_SESSION['node']) || strpos($_SESSION['node'], 'P') !== 0) {
    die('Diagnosa belum tersedia.');
}

$penyakit = [
    "P01"=>"Karat Daun",
    "P03"=>"Bercak Daun",
    "P11"=>"Hama Kutu Dompolan",
    "P14"=>"Hama Pengerek Buah"
];

$hasil = $penyakit[$_SESSION['node']];
$tanggal = date('d-m-Y');
$jam = date('H:i:s');

header("Content-Type: application/pdf");
header("Content-Disposition: inline; filename=laporan_diagnosa.pdf");

echo "%PDF-1.4
1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj
2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj
3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792]
/Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >> endobj
4 0 obj << /Length 250 >> stream
BT
/F1 14 Tf
72 720 Td (LAPORAN HASIL DIAGNOSA TANAMAN KOPI) Tj
0 -30 Td (Tanggal: $tanggal) Tj
0 -20 Td (Waktu: $jam) Tj
0 -30 Td (Hasil Diagnosa:) Tj
0 -20 Td ($hasil) Tj
ET
endstream endobj
5 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj
xref
0 6
0000000000 65535 f
0000000010 00000 n
0000000060 00000 n
0000000120 00000 n
0000000300 00000 n
0000000580 00000 n
trailer << /Size 6 /Root 1 0 R >>
startxref
650
%%EOF";
