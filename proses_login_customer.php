<?php
session_start();
// session_start () digunakan sebagai tanda kalau kita akan menggunakan session pada halaman curl_ini
// session_start() harus diletakkan pada baris pertama
include("config.php");

// tampung data ussername dan password
$username = $_POST["username"];
$password = $_POST["password"];

if (isset($_POST["login_customer"])) {
  $sql = " select * from customer where username = '$username' and password = '$password'";
  // eksekusi query
  $query = mysqli_query($connect, $sql);
  $jumlah = mysqli_num_rows($query);

  // mysqli_num_rows digunakan untuk menghitung jumlah data hasil query

  if ($jumlah > 0) {
    // jika jumlahnya lebih dari nol, artinya terdapat data admin sesuai dengan username dan password yang di inputkan
    // ini blok kode jika berhasil
    // kita ubah query ke array
    $customer = mysqli_fetch_array($query);

    // memuat sesion
    $_SESSION["id_customer"] = $customer["id_customer"];
    $_SESSION["nama"] = $customer["nama"];
    $_SESSION["cart"] = array();
    header("location:list_buku.php");
  }
  else {
    // ika jumlahnya nol, artinya tidak ada data admin yang sesuai dengan username dan password yang di inputkan
    // ini blok kode jika loginnya gagal/salah
    header("location:login_customer.php");
  }
}
if (isset($_GET["logout"])) {
  // proses logout
  // menghapus  data SessionHandler
  session_destroy();
  header("location:login_customer.php");
}
 ?>
