<?php include 'db.php';

    $limit = 5;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;
    $where = "";

    $count_query = mysqli_query($conn,"SELECT COUNT(*) AS total FROM barang"
    . ($where ? "$where" : ""));

    $total_data = mysqli_fetch_assoc($count_query)['total'];
    $total_pages = ceil($total_data / $limit);
    
    $kategori_query = mysqli_query($conn, "SELECT * FROM kategori");
    if (!$kategori_query) {
        echo "<div class='alert alert-danger'>
        Kategori Tidak Valid : " . mysqli_error($conn) . "</div>";
    }

    if (isset($_GET['search']) && $_GET['search'] != "") {
        $search = mysqli_real_escape_string($conn, $_GET['search']);
        $where .= "WHERE barang.nama_barang LIKE '%$search%'";
    }

    if (isset($_GET['kategori']) && $_GET['kategori'] != "") {
        $kat = intval($_GET['kategori']);
        $where .= $where ? "AND kategori_id=$kat" : "WHERE kategori_id=$kat";
    }

    $query = mysqli_query($conn, "
    SELECT barang.*, kategori.nama_kategori
    FROM barang AS barang
    LEFT JOIN kategori ON barang.kategori_id = kategori.id
    $where
    ORDER BY barang.id ASC
    LIMIT $limit OFFSET $offset");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen inventaris Barang</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<nav class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">Inventaris Barang</a>
        <div class="d-flex gap-2">
            <a href="index.php" class="btn btn-danger">Barang</a>
            <a href="kategori/index.php" class="btn btn-success">Kategori</a>
        </div>
    </div>
</nav>

<body class="bg-dark text-white">
    <div class="container mt-5"></div>
    <h2 class="mb-4 text-center text-primary">Manajemen inventaris Barang</h2>
    <?php if (isset($_GET['pesan'])): ?>
        <?php if ($_GET['pesan'] == 'sukses'): ?>
            <div class="alert alert-success text-center">Barang Sudah Ditambahkan</div>
        <?php elseif ($_GET['pesan'] == 'update_sukses'): ?>
            <div class="alert alert-info text-center">Barang Berhasil Diperbarui</div>
        <?php elseif ($_GET['pesan'] == 'hapus_sukses'): ?>
            <div class="alert alert-danger text-center">Barang Berhasil Dihapus</div>
        <?php endif; ?>
    <?php endif; ?>

    <form class="row mb-4 m-auto" style= "max-width: 900px;">
        <div class="col-md-4 mb-2">
            <input type="text" name="search" class="form-control" placeholder="Cari Nama Barang..." value="<?= $_GET['search'] ?? '' ?>">
        </div>
        <div class="col-md-4 mb-2">
            <select name="kategori" class="form-select">
                <option value="">Semua kategori</option>
                <?php while ($row = mysqli_fetch_assoc($kategori_query)) { ?>
                    <option value="<?= $row['id'] ?>" <?= (($_GET['kategori'] ?? '') == $row['id']) ? 'selected' : '' ?>>
                        <?= $row['nama_kategori'] ?>
                    </option>
                <?php } ?>
            </select>
            </div>
            <div class="col-md-4 mb-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="tambah.php" class="btn btn-success">Tambah Barang</a>
            </div>
    </form>

    <table class="table table-striped table-hover text-center align-middle" style="width: 90%; margin:auto;">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Tanggal Masuk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_assoc($query)) { ?>
                    <tr>
                        <td><?= $data['id'] ?></td>
                        <td><?= $data['nama_barang'] ?></td>
                        <td><?= $data{'nama_kategori'} ?></td>
                        <td><?= $data['stok'] ?></td>
                        <td>Rp <?= number_format($data['harga'], 0, ',', '.') ?></td>
                        <td><?= $data['tanggal_masuk'] ?></td>
                        <td>
                            <a href="edit.php?id=<?= $data['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus.php?id=<?= $data['id'] ?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>  
                <?php } ?>
            </tbody>
    </table>

    <nav aria-label="Page Navigasi" class="my-4">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= $_GET['search'] ?? '' ?>&kategori=<?= $_GET['kategori'] ?? '' ?>">Sebelum</a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&search=<?= $_GET['search'] ?? '' ?>&kategori=<?= $_GET['kategori'] ?? '' ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= $_GET['search'] ?? '' ?>&kategori=<?= $_GET['kategori'] ?? '' ?>">Selanjut</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <footer class="bg-dark text-light text-center py-3 mt-4">
        <div class="container">
            <p class="mb-0"><?= date('Y') ?> Manajemen Inventaris Barang — All Rights Reserved</p>
            <small class="text-secondary">Heru Riziq Risaldi</small>
        </div>
    </footer>
    <script src = "js/bootstrap.bundle.min.js"></script>
</body>
</html>