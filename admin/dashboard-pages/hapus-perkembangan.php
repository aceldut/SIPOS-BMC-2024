<?php
include '../../config.php';

if (isset($_POST['kode'])) {
    $kode = $_POST['kode'];

    // Query untuk menghapus data
    $query = "DELETE FROM tbl_perkembangananak WHERE kode = '$kode'";
    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }

    // Tutup koneksi database
    mysqli_close($conn);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
