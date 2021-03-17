<?php
include('koneksi/koneksi.php');
$penerbit = $_POST['penerbit'];
if (empty($penerbit)) {
    header("Location:tambahkategoriblog.php?notif=tambahkosong");
} else {
    $sql = "insert into `penerbit` (`penerbit`) values ('$penerbit')";
    mysqli_query($koneksi, $sql);
    header("Location:penerbit.php?notif=tambahberhasil");
}
