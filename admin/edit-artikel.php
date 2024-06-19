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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul_artikel = $_POST['judul_artikel'];
    $deskripsi_artikel = $_POST['deskripsi_artikel'];
    $id_admin = $_SESSION['id_admin'];

    // Handle file upload
    if (!empty($_FILES['img']['name'])) {
        $img = $_FILES['img']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($img);
        move_uploaded_file($_FILES['img']['tmp_name'], $target_file);
    } else {
        $img = $article['img'];
    }

    $query = "UPDATE tbl_artikel SET judul_artikel = ?, deskripsi_artikel = ?, img = ?, id_admin = ? WHERE kode_artikel = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssii", $judul_artikel, $deskripsi_artikel, $img, $id_admin, $kode_artikel);

    if ($stmt->execute()) {
        header("Location: artikel-page.php?success=1");
    } else {
        header("Location: edit_article.php?id=$kode_artikel&error=1");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Artikel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <h4>Edit Artikel</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="edit_article.php?id=<?php echo $kode_artikel; ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="judul_artikel">Judul Artikel</label>
                                <input type="text" class="form-control" id="judul_artikel" name="judul_artikel" value="<?php echo htmlspecialchars($article['judul_artikel']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi_artikel">Deskripsi Artikel</label>
                                <textarea class="form-control" id="deskripsi_artikel" name="deskripsi_artikel" rows="4" required><?php echo htmlspecialchars($article['deskripsi_artikel']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="img">Gambar</label>
                                <input type="file" class="form-control-file" id="img" name="img">
                                <img src="uploads/<?php echo htmlspecialchars($article['img']); ?>" alt="<?php echo htmlspecialchars($article['judul_artikel']); ?>" class="img-thumbnail mt-2" width="150">
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="artikel-page.php" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
