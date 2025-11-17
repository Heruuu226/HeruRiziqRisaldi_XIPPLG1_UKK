<?php include '../db.php'; 

    $result = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kategori</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>

<nav class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">Inventaris Barang</a>
        <div class="d-flex gap-2">
            <a href="../index.php" class="btn btn-success">Barang</a>
            <a href="index.php" class="btn btn-danger">Kategori</a>
        </div>
    </div>
</nav>

<body class="bg-dark text-white">
    <div class="container mt-5">
        <h3 class="text-primary text-center">Daftar Kategori Barang</h3>
        <?php if (isset($_GET['pesan'])): ?>
        <?php if ($_GET['pesan'] == 'sukses'): ?>
            <div class="alert alert-success text-center">Barang Sudah Ditambahkan</div>
        <?php elseif ($_GET['pesan'] == 'update_sukses'): ?>
            <div class="alert alert-info text-center">Barang Berhasil Diperbarui</div>
        <?php elseif ($_GET['pesan'] == 'hapus_sukses'): ?>
            <div class="alert alert-danger text-center">Barang Berhasil Dihapus</div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="col-md-4 mb-2 d-flex gap-2">
        <a href="tambah.php" class="btn btn-success">Tambah Kategori</a>
        <a href="../index.php" class="btn btn-secondary">Kembali ke Data Barang</a>
    </div>

    <table class="table table-striped table-hover text-center align-middle">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
                    <td class="text-center">
                        <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="hapus.php?id=<?= $row['id']; ?>" 
                           onclick="return confirm('Yakin hapus kategori?')"
                           class="btn btn-danger btn-sm">
                           Hapus
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>

    <footer class="bg-dark text-light text-center py-3 mt-4">
        <div class="container">
            <p class="mb-0"><?= date('Y') ?> Manajemen Inventaris Barang — All Rights Reserved</p>
            <small class="text-secondary">Heru Riziq Risaldi</small>
        </div>
    </footer>
    <script src = "../js/bootstrap.bundle.min.js"></script>
</body>
</html>