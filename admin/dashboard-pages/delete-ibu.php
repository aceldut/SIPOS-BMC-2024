<?php
include '../../config.php';

$id_ibu = $_POST['id_ibu'];

// Hapus data dari tabel `tbl_anak` terlebih dahulu
$sql_anak = "DELETE FROM tbl_anak WHERE id_ibu=?";
$stmt_anak = $conn->prepare($sql_anak);
$stmt_anak->bind_param("i", $id_ibu);
$stmt_anak->execute();
$stmt_anak->close();

// Hapus data dari tabel `tbl_ibu`
$sql = "DELETE FROM tbl_ibu WHERE id_ibu=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_ibu);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$conn->close();
?>
