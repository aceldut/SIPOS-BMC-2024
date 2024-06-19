<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek apakah username sudah terdaftar
    $sql_check_username = "SELECT COUNT(*) FROM tbl_admin WHERE username = ?";
    $stmt_check_username = $conn->prepare($sql_check_username);
    $stmt_check_username->bind_param("s", $username);
    $stmt_check_username->execute();
    $stmt_check_username->bind_result($username_count);
    $stmt_check_username->fetch();
    $stmt_check_username->close();

    if ($username_count > 0) {
        echo "error|Username sudah terdaftar";
        exit();
    }

    // Tambahkan admin baru
    $sql_add_admin = "INSERT INTO tbl_admin (username, password) VALUES (?, ?)";
    $stmt_add_admin = $conn->prepare($sql_add_admin);
    $stmt_add_admin->bind_param("ss", $username, $password);

    if ($stmt_add_admin->execute()) {
        echo "success";
    } else {
        echo "error|Gagal menambahkan admin";
    }

    $stmt_add_admin->close();
    $conn->close();
}
?>
