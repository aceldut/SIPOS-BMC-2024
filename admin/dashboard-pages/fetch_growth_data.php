<?php
include '../config.php';

$nama_anak = $_GET['nama_anak'] ?? '';

if (empty($nama_anak)) {
    echo json_encode(['error' => 'Nama anak tidak ditemukan']);
    exit();
}

$query = $conn->prepare("SELECT tanggal, tinggi FROM tbl_perkembangananak WHERE nama_anak = ?");
$query->bind_param("s", $nama_anak);
$query->execute();
$result = $query->get_result();

$dates = [];
$heights = [];

while ($row = $result->fetch_assoc()) {
    $dates[] = $row['tanggal'];
    $heights[] = $row['tinggi'];
}

echo json_encode(['dates' => $dates, 'heights' => $heights]);
?>
