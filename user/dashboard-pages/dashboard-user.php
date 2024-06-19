<?php
session_start();
if (!isset($_SESSION['id_ibu'])) {
    header("Location: ../../index.html");
    exit();
}

include '../../config.php';

$id_ibu = $_SESSION['id_ibu'];
$query = "SELECT * FROM tbl_ibu WHERE id_ibu = '$id_ibu'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nama_ibu = $row['nama_ibu'];
    $nik = $row['NIK'];
    $no_telp = $row['no_telp'];
    $alamat = $row['alamat'];
} else {
    echo "Data tidak ditemukan";
    exit();
}

// Menghitung jumlah data dalam tabel perkembangananak
$query_perkembangan = "SELECT COUNT(*) as total_perkembangan FROM tbl_perkembangananak";
$result_perkembangan = $conn->query($query_perkembangan);
$row_perkembangan = $result_perkembangan->fetch_assoc();
$total_perkembangan = $row_perkembangan['total_perkembangan'];

// Menghitung jumlah data dalam tabel imunisasi
$query_imunisasi = "SELECT COUNT(*) as total_imunisasi FROM tbl_imunisasi";
$result_imunisasi = $conn->query($query_imunisasi);
$row_imunisasi = $result_imunisasi->fetch_assoc();
$total_imunisasi = $row_imunisasi['total_imunisasi'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posyandu Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style/style-user.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="sidebar-sticky">
                    <div class="text-left mb-4">
                        <img src="../../assets/logo.png" alt="Logo" class="img-fluid">
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="dashboard-user.php">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../jadwal-user.html">
                                <i class="fas fa-calendar-alt"></i>
                                Jadwal
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../artikel-user.html">
                                <i class="fas fa-newspaper"></i>
                                Artikel
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../index.html">
                                <i class="fas fa-sign-out-alt"></i>
                                Keluar
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div id="main-content">
                    <!-- Initial Dashboard Content -->
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Dashboard</h1>
                    </div>
                    <div class="card card-custom mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Halo Ibu <?php echo $nama_ibu; ?></h5>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="card card-custom card-link" data-url="perkembangan-anak.php">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Perkembangan Anak</h5>
                                    <p class="card-text"><?php echo $total_perkembangan; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-custom card-link" data-url="imunisasi-anak.html">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Imunisasi</h5>
                                    <p class="card-text"><?php echo $total_imunisasi; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-1 card-form-custom">
                        <div class="card-header">
                            Data Anda
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th scope="row">NIK</th>
                                        <td>: <?php echo $nik; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Nama Ibu</th>
                                        <td>: <?php echo $nama_ibu; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">No Telp</th>
                                        <td>: <?php echo $no_telp; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Alamat</th>
                                        <td>: <?php echo $alamat; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <footer class="pt-4 my-md-5 pt-md-5 border-top">
                        <div class="d-flex justify-content-between">
                            <small class="d-block mb-3 text-muted">2024 © SIPOS</small>
                            <small class="d-block mb-3 text-muted">Crafted By BMC</small>
                        </div>
                    </footer>
                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();

        // Load content dynamically
        $(document).ready(function() {
            $('.card-link').on('click', function() {
                var url = $(this).data('url');
                $('#main-content').load(url);
            });
        });

        // Ambil URL saat ini
        var currentUrl = window.location.href;

        // Ambil semua link di sidebar
        var sidebarLinks = document.querySelectorAll('.sidebar .nav-link');

        // Loop melalui setiap link di sidebar
        sidebarLinks.forEach(function(link) {
            // Periksa apakah link adalah link aktif
            if (link.href === currentUrl) {
                link.classList.add('active'); // Tambahkan kelas 'active' untuk menunjukkan link aktif
            }
        });
    </script>
</body>
</html>
