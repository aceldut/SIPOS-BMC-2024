<?php
include '../config.php';

$query = "SELECT id_jadwal, foto FROM tbl_jadwal";
$result = $conn->query($query);

$images = [];
while ($row = $result->fetch_assoc()) {
    $images[] = [
        'id_jadwal' => $row['id_jadwal'],
        'foto' => base64_encode($row['foto'])
    ];
}

echo json_encode($images);

$conn->close();
?>
