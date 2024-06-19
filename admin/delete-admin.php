<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_admin = $_POST['id_admin'];

    // Hapus data dari tabel `tbl_admin`
    $sql = "DELETE FROM tbl_admin WHERE id_admin = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_admin);

    if ($stmt->execute()) {
        echo "success";
    } else {
        error_log("Error executing query: " . $stmt->error);
        echo "error";
    }

    $stmt->close();
    $conn->close();
}
?>
