<?php 
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username'])) {
    header ('loginadmin.php');
}


$host = "localhost";
$user = "root";
$pass = "";
$db = "vape";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
  die("tidak bisa terkoneksi ke database");
}

$id_barang = "";
$jenis_barang = "";
$merk= "";
$harga = "";
$stok = "";
$foto = "";
$error = "";
$sukses = "";

if (isset($_GET['op'])) {
  $op = $_GET['op'];
} else {
  $op = "";
}

if ($op == 'delete') {
  $id = $_GET['id'];
  $sql1 = "delete from barang where id_barang = '$id'";
  $q1 = mysqli_query($konek, $sql1);
  if ($q1) {
    $sukses = "Berhasil hapus data";
  } else {
    $error = "Gagal melakukan delete data";
  }
}

if ($op == 'edit') {
  $id = $_GET['id'];
  $sql1 = "select * from barang where id_barang = '$id'";
  $q1 = mysqli_query($koneksi, $sql1);
  $r1 = mysqli_fetch_array($q1);
  $id_barang = $r1['id_barang'];
  $jenis_barang = $r1['jenis_barang'];
  $merk = $r1['merk '];
  $harga = $r1['harga'];
  $stok = $r1['stok'];

  if ($id_barang == '') {
    $error = "Data tidak ditemukan";
  }
}
if (isset($_POST['simpan'])) { //untuk create
  $jenis_barang = $_POST['jenis_barang'];
  $merk = $_POST['merk'];
  $harga = $_POST['harga'];
  $stok = $_POST['stok'];
   $foto = $_FILES['foto']['name'];
   $ekstensi1=array('png','jpg','jpeg');
   $x=explode('.',$foto);
   $ekstensi=strtolower(end($x));
   $file_tmp=$_FILES['foto']['tmp_name'];
   if(in_array($ekstensi, $ekstensi1)===true){
    move_uploaded_file($file_tmp, 'img/'.$foto);
   }
   else{
    echo "<script>alert ('Eksentasi tidak diperbolehkan')</script>";
   }

  if ($id_barang && $jenis_barang && $merk && $harga && $stok && $foto) {
    if ($op == 'edit') { //untuk update
      $sql1 = "update barang set id_barang = '$id_barang', jenis_barang = '$jenis_barang', merk = '$merk', harga = '$harga', stok='$stok', foto='$foto' where id_barang='$_GET[id]'";
      $q1 = mysqli_query($koneksi, $sql1);
      if ($q1) {
        $sukses = "Data berhasil diupdate";
      } else {
        $error = "Data gagal diupdate";
      }
    } else { //untuk insert
      $sql1 = "insert into barang(id_barang,jenis_barang,merk,harga,stok,foto) values ('$id_barang','$jenis_barang','$merk','$harga','$stok','$foto')";
      $q1 = mysqli_query($koneksi, $sql1);
      if ($q1) {
        $sukses = "Berhasil memasukkan data baru";
      } else {
        $error = "Gagal memasukkan data";
      }
    }
  } else {
    $error = "Silahkan masukkan semua data";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vape Data</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <style>
    .mx-auto {
      width: 900px;
    }

    .card {
      margin-top: 10px;
    }
  </style>
</head>

<body>
  <div class="mx-auto">
    <!----untuk memasukan data---->
    <div class="card">
      <div class="card-header">
        Create / edit data <?$_SESSION['username']?>
      </div>
      <div class="card-body">
        <?php
        if ($error) {
          ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error ?>
          </div>
          <?php
          header("refresh:3;url=admin.php"); //5 : detik
        }
        ?>
        <?php
        if ($sukses) {
          ?>
          <div class="alert alert-success" role="alert">
            <?php echo $sukses ?>
          </div>
          <?php
          header("refresh:3;url=admin.php"); //5 : detik
        }
        ?>
        
        <form action="admin.php" method="POST" enctype="multipart/form-data">
           
          
          <div class="mb-3 row">
            <label for="jenis_barang" class="col-sm-2 col-form-label">jenis barang</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="jenis_barang" name="jenis_barang" value="<?php echo $jenis_barang ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="merk" class="col-sm-2 col-form-label">merk</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="merk" id="merk" value="<?php echo $merk ?>">
              </div>
            </div>
          <div class="mb-3 row">
            <label for="harga" class="col-sm-2 col-form-label">harga</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="harga" id="harga" value="<?php echo $harga ?>">
              </div>
            </div>
          <div class="mb-3 row">
            <label for="stok" class="col-sm-2 col-form-label">stok</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="stok" id="stok" value="<?php echo $stok ?>">
              </div>
            </div>
          <div class="mb-3 row">
            <label for="produk" class="col-sm-2 col-form-label">foto</label>
            <div class="col-sm-10">
              <input type="file" class="form-control" name="foto" id="foto" value="<?php echo $foto ?>">
                
                
              </div>
            </div>
            <div class="col-12">
              <input type="submit" name="simpan" value="Simpan data" class="btn btn-primary">
            </div>
          </form>
          <!--untuk mengeluarkan data-->

        </div>
      </div>
      <div class="card">
        <div class="card-header text-white bg-secondary">
          data mahasiswa
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nama vape</th>
                <th scope="col">merk</th>
                <th scope="col">harga</th>
                <th scope="col">stok</th>
                <th scope="col">Foto</th>
              </tr>
            <tbody>
              <?php
                $sql2 = "select * from barang order by id_barang";
                $q2 = mysqli_query($koneksi, $sql2);
                $urut = 1;
                while ($r2 = mysqli_fetch_array($q2)) {
                  $id_barang = $r2['id_barang'];
                  $jenis_barang = $r2['jenis_barang'];
                  $merk = $r2['merk'];
                  $harga = $r2['harga'];
                  $stok = $r2['stok'];
                  $foto = $r2['foto'];

                  ?>
              <tr>
                <th scope="row">
                  <?php echo $urut++ ?>
                </th>
                
                <td scope="row">
                  <?php echo $jenis_barang ?>
                </td>
                <td scope="row">
                  <?php echo $merk ?>
                </td>
                <td scope="row">
                  <?php echo $harga ?>
                </td>
                <td scope="row">
                  <?php echo $stok ?>
                </td>
                <td scope="row"><img src="img/<?= $foto?>" class="img-thumbnail" width="100px" height="100px">
                </td>
                <td scope="row">
                  <a href="admin.php?op=edit&id=<?php echo $id ?>"><button type="button"
                      class="btn btn-warning">Edit</button></a>
                  <a href="admin.php?op=delete&id=<?php echo $id ?>"> <button type="button" class="btn btn-danger"
                      onclick="return confirm('Yakin ingin delete data?')">Delete</button></a>
                </td>
              </tr>
              <?php
                }
                ?>
          </tbody>
          </thead>
        </table>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
      crossorigin="anonymous"></script>
</body>

</html>