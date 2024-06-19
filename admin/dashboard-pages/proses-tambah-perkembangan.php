<?php
include '../../config.php';

// Tambahkan log untuk metode request
file_put_contents('log.txt', $_SERVER['REQUEST_METHOD'], FILE_APPEND);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_anak = isset($_POST['id_anak']) ? $_POST['id_anak'] : '';
    $tanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : '';
    $berat_badan = isset($_POST['berat_badan']) ? $_POST['berat_badan'] : '';
    $keterangan_berat_badan = isset($_POST['keterangan_berat_badan']) ? $_POST['keterangan_berat_badan'] : '';
    $tinggi_badan = isset($_POST['tinggi_badan']) ? $_POST['tinggi_badan'] : '';
    $keterangan_tinggi_badan = isset($_POST['keterangan_tinggi_badan']) ? $_POST['keterangan_tinggi_badan'] : '';

    // Ensure all required fields are filled
    if (empty($id_anak) || empty($tanggal) || empty($berat_badan) || empty($keterangan_berat_badan) || empty($tinggi_badan) || empty($keterangan_tinggi_badan)) {
        echo json_encode(['status' => 'error', 'message' => 'Semua field wajib diisi.']);
        exit();
    }

    // Prepare an insert statement
    $sql = "INSERT INTO tbl_perkembangananak (id_anak, tanggal, berat_badan, ketbb, tinggi_badan, kettb) VALUES (?, ?, ?, ?, ?, ?)";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "issdss", $id_anak, $tanggal, $berat_badan, $keterangan_berat_badan, $tinggi_badan, $keterangan_tinggi_badan);
        
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mempersiapkan statement']);
    }

    mysqli_close($conn);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid']);
}
?>
