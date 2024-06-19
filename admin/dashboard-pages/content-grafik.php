<?php
session_start();
include '../../config.php';

if (!isset($_SESSION['id_admin'])) {
    header("Location: ../../index.html");
    exit();
}

$nama_anak = $_GET['nama_anak'] ?? '';
$tanggal_lahir = $_GET['tanggal_lahir'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Perkembangan Anak</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../style/style-admin.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Grafik Perkembangan Anak</h1>
                    <nav aria-label="breadcrumb" class="breadcrumb-custom">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="dashboard-page.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Grafik Perkembangan Anak</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <button type="button" class="btn btn-primary" onclick="history.back()">Kembali</button>
                </div>
                <div class="card card-custom">
                    <div class="card-body text-left">
                        <h5 class="card-title">Nama Anak: <?php echo htmlspecialchars($nama_anak); ?></h5>
                        <p>Umur Anak: <?php echo calculateAge($tanggal_lahir); ?></p>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="growthChart"></canvas>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            fetchGrowthData("<?php echo htmlspecialchars($nama_anak); ?>");
        });

        function fetchGrowthData(namaAnak) {
            $.ajax({
                url: 'fetch_growth_data.php',
                type: 'GET',
                data: { nama_anak: namaAnak },
                dataType: 'json',
                success: function(data) {
                    renderChart(data);
                },
                error: function() {
                    alert('Gagal mendapatkan data perkembangan.');
                }
            });
        }

        function renderChart(data) {
            var ctx = document.getElementById('growthChart').getContext('2d');
            var growthChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.dates,
                    datasets: [{
                        label: 'Tinggi Anak (cm)',
                        data: data.heights,
                        backgroundColor: 'rgba(0, 123, 255, 0.2)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'month'
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>
</body>

</html>

<?php
function calculateAge($birthDate) {
    $birthDate = new DateTime($birthDate);
    $today = new DateTime();
    $age = $today->diff($birthDate);
    return $age->y . ' Thn, ' . $age->m . ' Bln';
}
?>
