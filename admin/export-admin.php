<?php
require '../vendor/autoload.php';
include '../config.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set header
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Username');
$sheet->setCellValue('C1', 'Password');

// Fetch data admin
$sql = "SELECT id_admin, username, password FROM tbl_admin";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $rowNumber = 2;
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNumber, $row['id_admin']);
        $sheet->setCellValue('B' . $rowNumber, $row['username']);
        $sheet->setCellValue('C' . $rowNumber, $row['password']);
        $rowNumber++;
    }
}

$conn->close();

// Set the header to force download the file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="data-admin.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
