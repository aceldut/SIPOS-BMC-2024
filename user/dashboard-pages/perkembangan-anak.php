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

// Mengambil data perkembangan anak berdasarkan id_ibu
$query_perkembangan = "
    SELECT perkembangan.nama_anak, perkembangan.tanggal, perkembangan.berat_badan, perkembangan.ketbb, perkembangan.tinggi_badan, perkembangan.kettb 
    FROM tbl_perkembangananak AS perkembangan
    JOIN tbl_anak AS anak ON perkembangan.id_anak = anak.id_anak
    WHERE anak.id_ibu = '$id_ibu'
";
$result_perkembangan = $conn->query($query_perkembangan);
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
    <style>
        .table td,
        .table th {
            text-align: center;
            /* Center align text in table cells */
            vertical-align: middle;
            /* Vertically align text in table cells */
        }
    </style>
</head>

<body>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Perkembangan Anak</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="dashboard-user.php">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Data Perkembangan Anak
                </li>
            </ol>
        </nav>
    </div>
    <div class="card card-custom mb-3">
        <div class="card-body">
            <h5 class="card-title mb-3">Data Perkembangan Anak</h5>
            <div class="d-flex content-between mb-3">
                <input type="text" class="form-control w-25" placeholder="Search..." />
            </div>
            <table class="table table-hover table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Nama Anak</th>
                        <th scope="col">Tgl</th>
                        <th scope="col">Berat Badan</th>
                        <th scope="col">Ket Berat Badan</th>
                        <th scope="col">Tinggi Badan</th>
                        <th scope="col">Ket Tinggi Badan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_perkembangan->num_rows > 0) {
                        while ($row = $result_perkembangan->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['nama_anak'] . "</td>";
                            echo "<td>" . $row['tanggal'] . "</td>";
                            echo "<td>" . $row['berat_badan'] . " Kg</td>";
                            echo "<td>" . $row['ketbb'] . "</td>";
                            echo "<td>" . $row['tinggi_badan'] . " Cm</td>";
                            echo "<td>" . $row['kettb'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <footer class="pt-4 my-md-5 pt-md-5 border-top">
                <div class="d-flex justify-content-between">
                    <small class="d-block mb-3 text-muted">2024 © SIPOS</small>
                    <small class="d-block mb-3 text-muted">Crafted By BMC</small>
                </div>
            </footer>
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