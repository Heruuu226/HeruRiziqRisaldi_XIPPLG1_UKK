<?php 
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "inventaris";

    mysqli_report(MYSQLI_REPORT_OFF);

    $conn = @mysqli_connect($host, $user, $pass, $db);

    if (!$conn) {
        $error_message = htmlspecialchars(mysqli_connect_error());
        die ("<strong>Koneksi Gagal</strong><br>
        <strong>$error_message</strong><br></br>
        Silahkan Periksa Database Anda");
    }
?>