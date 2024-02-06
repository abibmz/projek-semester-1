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