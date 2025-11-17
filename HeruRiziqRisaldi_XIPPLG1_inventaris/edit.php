<?php include 'db.php'; 

    if (!isset($_GET['id'])) {
        header("location: index.php");
        exit;
    }

    $id = intval($_GET['id']);
    $result = mysqli_query($conn, "SELECT * FROM barang WHERE id = $id");
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        echo "<div class='alert alert-danger text-center'>
        Data Tidak Ditemukan</div>";
        exit;
    }

    if (isset($_POST['update'])) {
        $nama = $_POST['nama_barang'];
        $kategori = intval($_POST['kategori_id']);
        $stok = intval($_POST['stok']);
        $harga = floatval($_POST['harga']);
        $tanggal = $_POST['tanggal_masuk'];

        if ($nama == "" || $stok < 0 || $harga < 0) {
            echo "<div class='alert alert-danger text-center'>
            Input Tidak Valid!</div>";
        } else {
            mysqli_query($conn, "UPDATE barang SET
            nama_barang = '$nama',
            kategori_id = '$kategori',
            stok = '$stok',
            harga = '$harga',
            tanggal_masuk = '$tanggal' WHERE id=$id");
            header("location: index.php?pesan=update_sukses");
            exit;
        }
    }

    $kategori = mysqli_query($conn, "SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .container {
        max-width: 600px;
        margin-top: 50px;
    }
    .card {
        padding: 20px;
        border-radius: 0 0 8px rgba(0,0,0,0,1);
    }
    label {
        font-weight: 600;
    }
    .error-text {
        color: red; font-size: 0.875rem;
    }
</style>
<body class="bg-dark text-white opacity-250">
    <div class="container mt-5">
        <h3 class="mb-4 text-primary">Edit Barang</h3>
        <form method="POST">
            <div class="mb-3">
                <label>Nama Barang</label>
                <input type="text" name= "nama_barang" class="form-control" value="<?= $data['nama_barang'] ?>" required>
            </div>
            <div class="mb-3">
                <label>kategori</label>
                <select name="kategori_id" class="form-select">
                    <?php while ($row = mysqli_fetch_assoc($kategori)) { ?>
                        <option value="<?= $row['id'] ?>"><?= $row['nama_kategori'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control"  value="<?= $data['stok'] ?>">
            </div>
            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" value="<?= $data['harga'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" class="form-control" value="<?= $data['tanggal_masuk'] ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-success">Update</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
    <script src = "js/bootstrap.bundle.min.js"></script>
</body>
</html>