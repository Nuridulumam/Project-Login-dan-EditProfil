<!DOCTYPE html>
<html>
<?php
include('koneksi/koneksi.php');
if ((isset($_GET['aksi'])) && (isset($_GET['data']))) {
  if ($_GET['aksi'] == 'hapus') {
    $id_blog = $_GET['data'];
    //get cover 
    $sql_hb = "SELECT `judul` FROM `blog` WHERE `id_blog`='$id_blog'";
    $query_b = mysqli_query($koneksi, $sql_hb);

    $sql_dm = "delete from `blog` where `id_blog` = '$id_blog'";
    mysqli_query($koneksi, $sql_dm);
  }
}
?>

<head>
  <?php include("includes/head.php") ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include("includes/header.php") ?>

    <?php include("includes/sidebar.php") ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h3><i class="fab fa-blogger"></i> Blog</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active"> Blog</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title" style="margin-top:5px;"><i class="fas fa-list-ul"></i> Daftar Blog</h3>
            <div class="card-tools">
              <a href="tambahblog.php" class="btn btn-sm btn-info float-right">
                <i class="fas fa-plus"></i> Tambah Blog</a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="col-md-12">
              <form method="" action="">
                <div class="row">
                  <div class="col-md-4 bottom-10">
                    <input type="text" class="form-control" id="kata_kunci" name="katakunci">
                  </div>
                  <div class="col-md-5 bottom-10">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i>&nbsp; Search</button>
                  </div>
                </div><!-- .row -->
              </form>
            </div><br>
            <div class="col-sm-12">
              <?php if (!empty($_GET['notif'])) { ?>
                <?php if ($_GET['notif'] == "tambahberhasil") { ?>
                  <div class="alert alert-success" role="alert"> Data Berhasil Ditambahkan</div>
                <?php } else if ($_GET['notif'] == "editberhasil") { ?>
                  <div class="alert alert-success" role="alert"> Data Berhasil Diubah</div>
                <?php } ?>
              <?php } ?>
            </div>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th width="30%">Kategori</th>
                  <th width="30%">Judul</th>
                  <th width="20%">Tanggal</th>
                  <th width="15%">
                    <center>Aksi</center>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                $batas = 6;
                if (!isset($_GET['halaman'])) {
                  $posisi = 0;
                  $halaman = 1;
                } else {
                  $halaman = $_GET['halaman'];
                  $posisi = ($halaman - 1) * $batas;
                }
                // menampilkan data blog dengan pagination

                $sql_blog = "SELECT `b`.`id_blog`, `b`.`judul`, `b`.`tanggal`, `k`.`kategori_blog` FROM `blog` `b` INNER JOIN `kategori_blog` `k` ON `b`.`id_kategori_blog` = `k`.`id_kategori_blog`  ";
                if (isset($_GET["katakunci"])) {
                  $katakunci_blog = $_GET["katakunci"];
                  $sql_blog .= "where `kategori_blog` LIKE '%$katakunci_blog%'";
                }
                $sql_blog .= " ORDER BY `k`.`kategori_blog`, `b`.`judul` limit $posisi, $batas ";
                $query_blog = mysqli_query($koneksi, $sql_blog);
                $posisi = 1;
                while ($data_blog = mysqli_fetch_row($query_blog)) {
                  $id_blog = $data_blog[0];
                  $judul = $data_blog[1];
                  $kategori_blog = $data_blog[3];
                  $tanggal = $data_blog[2];
                ?>
                  <tr>
                    <td><?= $posisi; ?></td>
                    <td><?= $kategori_blog; ?></td>
                    <td><?= $judul; ?></td>
                    <td><?= $tanggal; ?></td>
                    <td align="center">
                      <a href="editblog.php?data=<?php echo $id_blog; ?>" class="btn btn-xs btn-info" title="Edit"><i class="fas fa-edit"></i></a>
                      <a href="detailblog.php?data=<?php echo $id_blog; ?>" class="btn btn-xs btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                      <a href="javascript:if(confirm('Anda yakin ingin menghapus data <?php echo $judul; ?>?')) window.location.href = 'blog.php?aksi=hapus&data=<?php echo $id_blog; ?>¬if=hapusberhasil'" class="btn btn-xs btn-warning" class="btn btn-xs btn-warning"><i class="fas fa-trash" title="Hapus"></i></a>
                    </td>
                  </tr>
                <?php $posisi++;
                } ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
              <!-- pagination -->
              <?php
              $sql_jum = "SELECT `b`.`id_blog`, `b`.`judul`, `b`.`tanggal`, `k`.`kategori_blog` FROM `blog` `b` INNER JOIN `kategori_blog` `k` ON `b`.`id_kategori_blog` = `k`.`id_kategori_blog` ";
              if (isset($_GET["katakunci"])) {
                $katakunci_blog = $_GET["katakunci"];
                $sql_jum .= " where `kategori_blog` LIKE '%$katakunci_blog%'";
              }
              $sql_jum .= " ORDER BY `k`.`kategori_blog`, `b`.`Judul`";
              $query_jum = mysqli_query($koneksi, $sql_jum);
              $jum_data = mysqli_num_rows($query_jum);
              $jum_halaman = ceil($jum_data / $batas);

              if ($jum_halaman == 0) {
                echo 'tidak ada halaman';
              } else if ($jum_halaman == 1) {
                echo "<li class='page-item'><a class='page-link'>1</a></li>";
              } else {
                $sebelum = $halaman - 1;
                $setelah = $halaman + 1;
                if (isset($_GET["katakunci"])) {
                  $katakunci_blog = $_GET["katakunci"];
                  if ($halaman != 1) {
                    echo "<li class='page-item'> <a class='page-link' href='blog.php?katakunci=$katakunci_blog &halaman=1'>First</a></li>";
                    echo "<li class='page-item'><a class='page-link' href='blog.php?katakunci=$katakunci_blog& halaman=$sebelum'> «</a></li>";
                  }
                  for ($i = 1; $i <= $jum_halaman; $i++) {
                    if ($i > $halaman - 5 and $i < $halaman + 5) {
                      if ($i != $halaman) {
                        echo "<li class='page-item'><a class='page-link' href='blog.php?katakunci =$katakunci_blog&halaman=$i'> $i</a></li>";
                      } else {
                        echo "<li class='page-item'> <a class='page-link'>$i</a></li>";
                      }
                    }
                  }
                  if ($halaman != $jum_halaman) {
                    echo "<li class='page-item'> <a class='page-link' href='blog.php?katakunci=$katakunci_blog &halaman=$setelah'>»</a></li>";
                    echo "<li class='page-item'><a class='page-link' href='blog.php?katakunci= $katakunci_blog&halaman=$jum_halaman'> Last</a></li>";
                  }
                } else {
                  if ($halaman != 1) {
                    echo "<li class='page-item'><a class='page-link' href='blog.php?halaman=1'>First</a></li>";
                    echo "<li class='page-item'><a class='page-link' href='blog.php? halaman=$sebelum'>«</a></li>";
                  }
                  for ($i = 1; $i <= $jum_halaman; $i++) {
                    if ($i > $halaman - 5 and $i < $halaman + 5) {
                      if ($i != $halaman) {
                        echo "<li class='page-item'><a class='page-link' href='blog.php?halaman=$i'>$i</a></li>";
                      } else {
                        echo "<li class='page-item'><a class='page-link'>$i</a></li>";
                      }
                    }
                  }
                  if ($halaman != $jum_halaman) {
                    echo "<li class='page-item'><a class='page-link' href='blog.php?halaman=$setelah'> »</a></li>";
                    echo "<li class='page-item'><a class='page-link' href='blog.php? halaman=$jum_halaman'>Last</a></li>";
                  }
                }
              } ?>
            </ul>
          </div>
        </div>
        <!-- /.card -->

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include("includes/footer.php") ?>

  </div>
  <!-- ./wrapper -->

  <?php include("includes/script.php") ?>
</body>

</html>