<?php include 'db.php'; 

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = "DELETE FROM barang WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("location: index.php?pesan=hapus_sukses");
        exit;
    } else {
        echo "<div class= 'alert alert-danger text-center'>Gagal Mengahapus Data></div>";
    }
} else {
    header("location: index.php");
    exit;
}
?>