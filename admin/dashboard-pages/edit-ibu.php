<?php
include '../../config.php';

$id_ibu = $_POST['id_ibu'];
$nik = $_POST['NIK'];
$nama_ibu = $_POST['nama_ibu'];
$no_telp = $_POST['no_telp'];
$alamat = $_POST['alamat'];

// Periksa apakah NIK sudah ada (kecuali untuk ibu yang sedang diedit)
$sql_check = "SELECT * FROM tbl_ibu WHERE NIK = ? AND id_ibu != ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("si", $nik, $id_ibu);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo "nik_exists";
} else {
    $sql = "UPDATE tbl_ibu SET NIK = ?, nama_ibu = ?, no_telp = ?, alamat = ? WHERE id_ibu = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nik, $nama_ibu, $no_telp, $alamat, $id_ibu);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
}

$stmt_check->close();
$conn->close();
?>
