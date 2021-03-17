<?php
session_start();
include('koneksi/koneksi.php');
if (isset($_SESSION['id_tag'])) {
    $id_tag = $_SESSION['id_tag'];
    $tag = $_POST['tag'];
    if (empty($tag)) {
        header("Location:editkategoritag.php?data=" . $id_kategori_tag . "¬if=editkosong");
    } else {
        $sql = "update `tag` set `tag`='$tag' where `id_tag`='$id_tag'";
        mysqli_query($koneksi, $sql);
        header("Location:tag.php?notif=editberhasil");
    }
}
