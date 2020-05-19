<?php

$host = "localhost";
$username = "root";
$password = "";
$db = "toko_buku";
$connect = mysqli_connect($host, $username, $password, $db);

if(mysqli_connect_errno()){
  echo mysqli_connect_error();
}else{
  echo "koneksi berhasil";
}
 ?>
