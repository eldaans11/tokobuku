<?php
session_start();
//session_start() digunakan sebagai tanda kalau kita akan menggunakan session pada halaman ini
//session_start() harus di letakkan pada baris pertama
include("config.php");

// tampung data user name dan passwordnya
$username = $_POST["username"];
$password = $_POST["password"];

if (isset($_POST["login_admin"])){
  $sql = "select * from admin where username = '$username' and password = '$password'";
  // eksekusi $query
  $query = mysqli_query($connect, $sql);
  $jumlah = mysqli_num_rows($query);
  // mysqil_num_rows digunakan untuk menghitung jumlah data hasil query

  if ($jumlah > 0) {
    // jika jumlahnya lebih dari 0, artinya terdapat data admin yang sesuai dengan username dan passwod yang di inputkan
    // ini blok kode jika login berhasil
    $admin = mysqli_fetch_array($query);

    //membuat session
    $_SESSION["id_admin"] = $admin["id_admin"];
    $_SESSION["nama"] = $admin["nama"];

    header("location:admin.php");
  }else {
    // jika jumlahnya nol, artinya tidak ada data adminyang sesuai dengan username dan password yang di inputkan
    // ini blok kode jika login gagal / salah
    header("location:login_admin.php");
  }
  echo $sql;
}

if (isset($_GET["logout"])) {
  // prosses log out
  // menghapus data session yang telah dibuat.
  session_destroy();
  header("location:login_admin.php");
}
  ?>
