<?php
session_start();
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Validasi ukuran file
        if ($_FILES['image']['size'] > 40 * 1024 * 1024) { // 40MB
            echo "error|File terlalu besar. Maksimal ukuran file adalah 40MB.";
            exit();
        }

        // Validasi tipe file
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
            echo "error|Tipe file tidak valid. Hanya file gambar yang diperbolehkan.";
            exit();
        }

        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        $id_admin = $_SESSION['id_admin']; // Pastikan id_admin sudah ada di session

        // Masukkan gambar ke database
        $stmt = $conn->prepare("INSERT INTO tbl_jadwal (id_admin, foto) VALUES (?, ?)");
        $stmt->bind_param("ib", $id_admin, $null);
        $stmt->send_long_data(1, $imageData);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error|Gagal menyimpan gambar ke database.";
        }

        $stmt->close();
    } else {
        echo "error|Tidak ada file yang diupload atau terjadi kesalahan.";
    }
} else {
    echo "error|Metode pengiriman salah.";
}
$conn->close();
?>
