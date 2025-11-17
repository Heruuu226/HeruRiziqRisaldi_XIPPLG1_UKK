<?php include 'db.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $nama = $_POST['nama_barang'];
    $kategori = intval($_POST['kategori_id']);
    $stok = intval($_POST['stok']);
    $harga = floatval($_POST['harga']);
    $tanggal = $_POST['tanggal_masuk'];

    $query = "INSERT INTO barang (nama_barang, kategori_id, stok, harga, tanggal_masuk)
        VALUES ('$nama', '$kategori', '$stok', '$harga', '$tanggal')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        header("location: Index.php?pesan=sukses");
        exit;
    } else {
        echo "<div class='alert alert-danger'>
            Gagal Menyimpan Data : " . mysqli_error($conn) . "</div>";
    }
}

$kategori = mysqli_query($conn, "SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
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
        <h3 class="mb-4 text-primary">Tambah Barang</h3>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form id="formBarang" method="POST">
            <div class="mb-3">
                <label>Nama Barang</label>
                <input type="text" id="nama_barang" name="nama_barang" class="form-control">
                <small id="nama_error" class="text-danger error-text"></small>
            </div>

            <div class="mb-3">
                <label>Kategori</label>
                <select id="kategori_id" name="kategori_id" class="form-select">
                    <?php while ($row = mysqli_fetch_assoc($kategori)) { ?>
                        <option value="<?= $row['id'] ?>"><?= $row['nama_kategori'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Stok</label>
                <input type="number" id="stok" name="stok" class="form-control">
                <small id="stok_error" class="text-danger error-text"></small>
            </div>

            <div class="mb-3">
                <label>Harga</label>
                <input type="number" id="harga" name="harga" class="form-control">
                <small id="harga_error" class="text-danger error-text"></small>
            </div>

            <div class="mb-3">
                <label>Tanggal Masuk</label>
                <input type="date" id="tanggal_masuk" name="tanggal_masuk" class="form-control">
                <small id="tanggal_error" class="text-danger error-text"></small>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formBarang');

    form.addEventListener('submit', function(e) {
        e.preventDefault(); 
        let valid = true;
        const nama = document.getElementById('nama_barang').value.trim();
        const stok = document.getElementById('stok').value.trim();
        const harga = document.getElementById('harga').value.trim();
        const tanggal = document.getElementById('tanggal_masuk').value.trim();

        document.querySelectorAll('.error-text').forEach(el => el.textContent = '');

        if (nama === "") {
            document.getElementById('nama_error').textContent = "Nama Barang wajib diisi";
            valid = false;
        }

        if (stok === "" || isNaN(stok) || stok < 0) {
            document.getElementById('stok_error').textContent = "Stok harus angka positif Dan Tidak Boleh Kosong";
            valid = false;
        }

        if (harga === "" || isNaN(harga) || harga < 0) {
            document.getElementById('harga_error').textContent = "Harga harus angka positif Dan Tidak Boleh Kosong";
            valid = false;
        }

        if (tanggal === "") {
            document.getElementById('tanggal_error').textContent = "Tanggal masuk wajib diisi";
            valid = false;
        }

        if (valid) {
            form.submit();
        }
    });
});
</script>
<script src = "js/bootstrap.bundle.min.js"></script>
</body>
</html>