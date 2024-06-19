<?php
session_start();
include '../config.php';

if (!isset($_SESSION['id_admin'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Query to get counts from the database
$counts = [];

// Count records in tbl_perkembangananak
$result = $conn->query("SELECT COUNT(*) AS count FROM tbl_perkembangananak");
if ($result) {
    $row = $result->fetch_assoc();
    $counts['perkembangananak'] = $row['count'];
} else {
    $counts['perkembangananak'] = 0;
}

// Count records in tbl_imunisasi
$result = $conn->query("SELECT COUNT(*) AS count FROM tbl_imunisasi");
if ($result) {
    $row = $result->fetch_assoc();
    $counts['imunisasi'] = $row['count'];
} else {
    $counts['imunisasi'] = 0;
}

// Count records in tbl_anak
$result = $conn->query("SELECT COUNT(*) AS count FROM tbl_anak");
if ($result) {
    $row = $result->fetch_assoc();
    $counts['data_anak'] = $row['count'];
} else {
    $counts['data_anak'] = 0;
}

echo json_encode($counts);
$conn->close();
?>
