<?php
session_start();
include('koneksi/koneksi.php');
if (isset($_SESSION['id_penerbit'])) {
    $id_penerbit = $_SESSION['id_penerbit'];
    $penerbit = $_POST['penerbit'];
    if (empty($penerbit)) {
        header("Location:editkategoripenerbit.php?data=" . $id_kategori_penerbit . "¬if=editkosong");
    } else {
        $sql = "update `penerbit` set `penerbit`='$penerbit' where `id_penerbit`='$id_penerbit'";
        mysqli_query($koneksi, $sql);
        header("Location:penerbit.php?notif=editberhasil");
    }
}
