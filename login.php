<?php
session_start();
require_once 'config.php';

// Memproses data login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek di tabel admin
    $sql_admin = "SELECT id_admin FROM tbl_admin WHERE username = ? AND password = ?";
    $stmt_admin = $conn->prepare($sql_admin);
    $stmt_admin->bind_param("ss", $username, $password);
    $stmt_admin->execute();
    $stmt_admin->bind_result($id_admin);
    $stmt_admin->fetch();
    $stmt_admin->close();

    if ($id_admin) {
        $_SESSION['id_admin'] = $id_admin; // Simpan id_admin di sesi
        header("Location: admin/dashboard-pages/dashboard-page.php");
        exit();
    }

    // Cek di tabel ibu
    $sql_ibu = "SELECT id_ibu FROM tbl_ibu WHERE NIK = ? AND NIK = ?";
    $stmt_ibu = $conn->prepare($sql_ibu);
    $stmt_ibu->bind_param("ss", $username, $username); // Asumsikan username dan password adalah NIK
    $stmt_ibu->execute();
    $stmt_ibu->bind_result($id_ibu);
    $stmt_ibu->fetch();
    $stmt_ibu->close();

    if ($id_ibu) {
        $_SESSION['id_ibu'] = $id_ibu; // Simpan id_ibu di sesi
        header("Location: user/dashboard-pages/dashboard-user.php");
        exit();
    }

    // Jika tidak ditemukan di kedua tabel
    echo "<script>alert('Username atau password salah!'); window.location.href = 'index.html';</script>";
}

$conn->close();
?>
