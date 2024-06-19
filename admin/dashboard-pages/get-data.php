<?php
require_once '../../config.phpphp';

// Mengambil data orang tua
$sql_ortu = "SELECT COUNT(*) AS count_ortu FROM tbl_ibu";
$result_ortu = $conn->query($sql_ortu);
$row_ortu = $result_ortu->fetch_assoc();
$count_ortu = $row_ortu['count_ortu'];

// Mengambil data anak
$sql_anak = "SELECT COUNT(*) AS count_anak FROM tbl_anak";
$result_anak = $conn->query($sql_anak);
$row_anak = $result_anak->fetch_assoc();
$count_anak = $row_anak->count_anak;

$conn->close();

$data = [
    'count_ortu' => $count_ortu,
    'count_anak' => $count_anak
];

header('Content-Type: application/json');
echo json_encode($data);
?>
