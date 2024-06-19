<?php
session_start();
if (!isset($_SESSION['id_admin'])) {
    header("Location: ../index.html"); // Redirect to login if not logged in
    exit();
}
$id_admin = $_SESSION['id_admin'];

include '../config.php'; // Make sure to include your database connection

$query = "SELECT * FROM tbl_artikel ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style/style-admin.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="sidebar-sticky">
                    <div class="text-left mb-4">
                        <img src="../assets/logo.png" alt="Logo" class="img-fluid">
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard-pages/dashboard-page.php">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="jadwal-page.html">
                                <i class="fas fa-calendar-alt"></i>
                                Jadwal
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="petugas-page.html">
                                <i class="fas fa-user"></i>
                                Petugas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="artikel-page.php">
                                <i class="fas fa-newspaper"></i>
                                Artikel
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../index.html">
                                <i class="fas fa-sign-out-alt"></i>
                                Keluar
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Artikel</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard-pages/dashboard-page.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Artikel</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createArticleModal">+ Buat Artikel</button>
                </div>
                
                <!-- Articles Section -->
                <div class="row">
                    <?php while($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="uploads/<?php echo htmlspecialchars($row['img']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['judul_artikel']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['judul_artikel']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars(substr($row['deskripsi_artikel'], 0, 100)); ?>...</p>
                                <a href="edit_article.php?id=<?php echo $row['kode_artikel']; ?>" class="btn btn-warning">Edit</a>
                                <a href="delete_article.php?id=<?php echo $row['kode_artikel']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">Hapus</a>
                            </div>
                            <div class="card-footer text-muted">
                                Diposting pada <?php echo date('d M Y', strtotime($row['created_at'])); ?>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>

                <!-- Additional content for Artikel can go here -->
                <footer class="pt-4 my-md-5 pt-md-5 border-top">
                    <div class="d-flex justify-content-between">
                        <small class="d-block mb-3 text-muted">2024 © SIPOS</small>
                        <small class="d-block mb-3 text-muted">Crafted By BMC</small>
                    </div>
                </footer>
            </main>
        </div>
    </div>

    <!-- Modal for creating a new article -->
    <div class="modal fade" id="createArticleModal" tabindex="-1" role="dialog" aria-labelledby="createArticleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createArticleModalLabel">Buat Artikel Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createArticleForm" method="POST" action="save-artikel.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="judul_artikel">Judul Artikel</label>
                            <input type="text" class="form-control" id="judul_artikel" name="judul_artikel" required>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi_artikel">Deskripsi Artikel</label>
                            <textarea class="form-control" id="deskripsi_artikel" name="deskripsi_artikel" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="img">Gambar</label>
                            <input type="file" class="form-control-file" id="img" name="img" required>
                        </div>
                        <input type="hidden" id="id_admin" name="id_admin" value="<?php echo $id_admin; ?>">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace()
    </script>
</body>
</html>
