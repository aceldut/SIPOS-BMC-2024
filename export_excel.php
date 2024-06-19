<?php
// Include PhpSpreadsheet autoloader
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include 'config.php';

$sql = "SELECT tbl_ibu.id_ibu, tbl_ibu.NIK, tbl_ibu.nama_ibu, tbl_ibu.no_telp, tbl_ibu.alamat, GROUP_CONCAT(tbl_anak.nama_anak SEPARATOR ', ') AS nama_anak 
        FROM tbl_ibu 
        LEFT JOIN tbl_anak ON tbl_ibu.id_ibu = tbl_anak.id_ibu
        GROUP BY tbl_ibu.id_ibu";
$result = $conn->query($sql);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'NIK');
$sheet->setCellValue('B1', 'Nama Ibu');
$sheet->setCellValue('C1', 'No Telp');
$sheet->setCellValue('D1', 'Alamat');
$sheet->setCellValue('E1', 'Anak');

if ($result->num_rows > 0) {
    $rowNumber = 2;
    while($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNumber, $row['NIK']);
        $sheet->setCellValue('B' . $rowNumber, $row['nama_ibu']);
        $sheet->setCellValue('C' . $rowNumber, $row['no_telp']);
        $sheet->setCellValue('D' . $rowNumber, $row['alamat']);
        $sheet->setCellValue('E' . $rowNumber, $row['nama_anak']);
        $rowNumber++;
    }
}

$writer = new Xlsx($spreadsheet);
$filename = 'Data_Orang_Tua.xlsx';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
?>
