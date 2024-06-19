<?php
session_start();
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST['nik'];
    $nama_ibu = $_POST['namaIbu'];
    $no_telp = $_POST['noTelp'];
    $alamat = $_POST['alamat'];
    $nama_anak = $_POST['namaAnak'];
    $jenis_kelamin = $_POST['jenisKelamin'];
    $tempat_lahir = $_POST['tempatLahir'];
    $tanggal_lahir = $_POST['tanggalLahir'];

    // $id_admin = $_SESSION['id_admin']; // Mengambil id_admin dari sesi

    // Validasi panjang NIK
    if (strlen($nik) != 16 || !ctype_digit($nik)) {
        header("Location: dashboard-pages/dashboard-page.php?message=NIK harus terdiri dari 16 angka.&type=error");
        exit();
    }

    // Validasi panjang no_telp
    if (strlen($no_telp) < 11 || strlen($no_telp) > 14 || !ctype_digit($no_telp)) {
        header("Location: dashboard-pages/dashboard-page.php?message=No Telp harus terdiri dari 11-14 angka.&type=error");
        exit();
    }

    // Cek apakah NIK sudah terdaftar
    $sql_check_nik = "SELECT COUNT(*) FROM tbl_ibu WHERE NIK = ?";
    $stmt_check_nik = $conn->prepare($sql_check_nik);
    $stmt_check_nik->bind_param("s", $nik);
    $stmt_check_nik->execute();
    $stmt_check_nik->bind_result($nik_count);
    $stmt_check_nik->fetch();
    $stmt_check_nik->close();

    if ($nik_count > 0) {
        header("Location: dashboard-pages/dashboard-page.php?message=NIK sudah terdaftar.&type=error");
        exit();
    }

    // Insert data into tbl_ibu
    $sql_ibu = "INSERT INTO tbl_ibu (NIK, nama_ibu, no_telp, alamat) 
                VALUES (?, ?, ?, ?)";
    $stmt_ibu = $conn->prepare($sql_ibu);
    $stmt_ibu->bind_param("ssss", $nik, $nama_ibu, $no_telp, $alamat);

    if ($stmt_ibu->execute()) {
        $id_ibu = $conn->insert_id; // Mengambil id_ibu yang baru saja ditambahkan

        // Insert data into tbl_anak
        $sql_anak = "INSERT INTO tbl_anak (nama_anak, tempat_lahir, tanggal_lahir, jenis_kelamin, id_ibu) 
                     VALUES (?, ?, ?, ?, ?)";
        $stmt_anak = $conn->prepare($sql_anak);
        $stmt_anak->bind_param("ssssi", $nama_anak, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $id_ibu);

        if ($stmt_anak->execute()) {
            header("Location: dashboard-pages/dashboard-page.php?message=Data berhasil ditambahkan.&type=success");
        } else {
            header("Location: dashboard-pages/dashboard-page.php?message=Error: " . $stmt_anak->error . "&type=error");
        }
        $stmt_anak->close();
    } else {
        header("Location: dashboard-pages/dashboard-page.php?message=Error: " . $stmt_ibu->error . "&type=error");
    }
    $stmt_ibu->close();
    $conn->close();
}
?>
