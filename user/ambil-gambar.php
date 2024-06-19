<?php
include '../config.php';

$sql = "SELECT foto FROM tbl_jadwal ORDER BY id_jadwal DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    header("Content-Type: image/jpeg"); // Sesuaikan dengan tipe gambar yang Anda simpan, misalnya image/png untuk PNG
    echo $row['foto'];
} else {
    echo "Tidak ada gambar.";
}
$conn->close();
?>
