<?php include '../db.php'; 

    $errors = [];
    $nama = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = trim($_POST['nama_kategori']);

        $query = "INSERT INTO kategori (nama_kategori) VALUES ('$nama')";
        if (mysqli_query($conn, $query)) {
            header("Location: index.php?success=1");
            exit;
        } else {
            echo "<div class='alert alert-danger'>
            Gagal Menyimpan Data : " . mysqli_error($conn) . "</div>";
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
            max-width:600px;
             margin-top:50px;
        }
        .card{
            padding:20px; 
            border-radius:10px; 
            box-shadow:0 0 8px rgba(0,0,0,0.1);
        }
        label{
            font-weight:600;
        }
    </style>
<body class="bg-dark text-white opacity-250">

    <div class="container mt-5">
    <h3 class="mb-4 text-primary">Tambah Kategori</h3>

    <div class="card">

        <?php if (!empty($errors)) : ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div><br>
        <?php endif; ?>

        <form method="POST" id="formKategori">
            <div class="mb-3">
                <label>Nama Kategori</label>
                <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" 
                       value="<?= htmlspecialchars($nama); ?>">
                <small id="nama_error" class="text-danger"></small>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>

    </div>
</div>

<script>
document.getElementById('formKategori').addEventListener('submit', function(e){
    let nama = document.getElementById('nama_kategori').value.trim();
    let error = document.getElementById('nama_error');
    error.textContent = "";

    if (nama === "") {
        e.preventDefault();
        error.textContent = "Nama kategori wajib diisi.";
    } else if (nama.length < 3) {
        e.preventDefault();
        error.textContent = "Nama kategori minimal 3 karakter.";
    }
});
</script>
    <script src = "../js/bootstrap.bundle.min.js"></script>
</body>
</html>