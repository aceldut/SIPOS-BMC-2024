<?php
session_start();
if (!isset($_SESSION['id_admin'])) {
    header("Location: ../index.html");
    exit();
}

include '../config.php';

if (isset($_GET['id'])) {
    $kode_artikel = $_GET['id'];
    $query = "SELECT * FROM tbl_artikel WHERE kode_artikel = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $kode_artikel);
    $stmt->execute();
    $result = $stmt->get_result();
    $article = $result->fetch_assoc();
} else {
    header("Location: artikel-page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['judul_artikel']); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <img src="uploads/<?php echo htmlspecialchars($article['img']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($article['judul_artikel']); ?>">
                    <div class="card-body">
                        <h2 class="card-title"><?php echo htmlspecialchars($article['judul_artikel']); ?></h2>
                        <p class="card-text"><?php echo nl2br(htmlspecialchars($article['deskripsi_artikel'])); ?></p>
                        <p class="text-muted">Diposting pada <?php echo date('d M Y', strtotime($article['created_at'])); ?></p>
                        <a href="artikel-page.php" class="btn btn-primary">Kembali ke Artikel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
