<?php 
include '../db.php';

    if (!isset($_GET['id'])) {
    header("location: index.php");
    exit;
}

    $id = intval($_GET['id']);
    $result = mysqli_query($conn, "SELECT * FROM kategori WHERE id = $id");
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
    echo "<div class='alert alert-danger text-center'>Data Tidak Ditemukan!</div>";
    exit;
}

    if (isset($_POST['update'])) {
    $nama = trim($_POST['nama_kategori']);

    if ($nama == "") {
        echo "<div class='alert alert-danger text-center'>Nama kategori tidak boleh kosong!</div>";
    } else {
        mysqli_query($conn, "UPDATE kategori SET 
            nama_kategori = '$nama'
        WHERE id = $id");

        header("location: index.php?pesan=update_sukses");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
        .container{
            max-width:600px; margin-top:50px;
        }
        .card{
            padding:20px; border-radius:10px; 
            box-shadow:0 0 8px rgba(0,0,0,0.1);
        }
        label{ font-weight:600; }
    </style>
<body class="bg-dark text-white opacity-250">

    <div class="container mt-5">
    <h3 class="mb-4 text-primary">Edit Kategori</h3>
    <div class="card">
        <form method="POST">
            <div class="mb-3">
                <label>Nama Kategori</label>
                <input 
                    type="text" 
                    name="nama_kategori" 
                    class="form-control" 
                    value="<?= htmlspecialchars($data['nama_kategori']) ?>" 
                    required>
            </div>

            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
    <script src = "../js/bootstrap.bundle.min.js"></script>
</body>
</html>
