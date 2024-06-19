<?php
include '../../config.php';

$id_ibu = $_POST['id_ibu'];
$nama_anak = $_POST['nama_anak'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$jenis_kelamin = $_POST['jenis_kelamin'];

$sql = "INSERT INTO tbl_anak (id_ibu, nama_anak, tempat_lahir, tanggal_lahir, jenis_kelamin) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issss", $id_ibu, $nama_anak, $tempat_lahir, $tanggal_lahir, $jenis_kelamin);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$conn->close();
?>
