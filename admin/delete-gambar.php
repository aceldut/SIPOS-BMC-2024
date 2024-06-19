<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_jadwal = $_POST['id_jadwal'];
    
    $stmt = $conn->prepare("DELETE FROM tbl_jadwal WHERE id_jadwal = ?");
    $stmt->bind_param("i", $id_jadwal);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
}
$conn->close();
?>
