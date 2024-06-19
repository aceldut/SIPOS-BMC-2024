<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config.php'; // Make sure to include your database connection

    $judul_artikel = $_POST['judul_artikel'];
    $deskripsi_artikel = $_POST['deskripsi_artikel'];
    $id_admin = $_SESSION['id_admin']; // Retrieve id_admin from session

    // Handle file upload
    $img = $_FILES['img']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($img);
    if (move_uploaded_file($_FILES['img']['tmp_name'], $target_file)) {
        $query = "INSERT INTO tbl_artikel (judul_artikel, deskripsi_artikel, img, id_admin) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $judul_artikel, $deskripsi_artikel, $img, $id_admin);

        if ($stmt->execute()) {
            header("Location: artikel-page.php?success=1");
        } else {
            header("Location: artikel-page.php?error=1");
        }
    } else {
        header("Location: artikel-page.php?error=1");
    }
}
?>
