<?php
include '../../config.php';

// Mengembalikan jumlah data orang tua
$sql_count = "SELECT COUNT(*) AS count FROM tbl_ibu";
$result_count = $conn->query($sql_count);
$count = $result_count->fetch_assoc()['count'];

echo json_encode(['count' => $count]);

$conn->close();
?>
