<?php
include("config.php");
//  memanggil file config
if (isset($_POST["save_buku"])) {

  $action = $_POST["action"];
  $kode_buku = $_POST["kode_buku"];
  $judul= $_POST["judul"];
  $penulis = $_POST["penulis"];
  $tahun = $_POST["tahun"];
  $harga = $_POST["harga"];
  $stok = $_POST["stok"];

  if (!empty($_FILES["image"]["name"])) {
    $path = pathinfo($_FILES["image"]["name"]);
    // mengambil ekstensi gambar
    $extension = $path["extension"];

    // rangkai filename-nya
    $filename = $kode_buku."-".rand(1,1000).".".$extension;

  }

  // cek aksinya
  if ($action == "insert") {
    // sintak untuk insert
    $sql = "insert into buku values ('$kode_buku','$judul','$penulis','$tahun',
    '$harga','$stok','$filename')";

    // proses upload file
    move_uploaded_file($_FILES["image"]["tmp_name"],"image/$filename");

    // eksekusi perintah SQL nya
    mysqli_query($connect, $sql);

  }elseif ($action == "update") {
  // if (isset($_FILES["image"])) {
  if (!empty($_FILES["image"]["name"])) {

    $path = pathinfo($_FILES["image"]["name"]);
    // mengambil ekstensi gambar
    $extension = $path["extension"];

    // rangkai filename-nya
    $filename = $kode_buku."-".rand(1,1000).".".$extension;
    // generate nama file
    // exp: 111-989.jpg
    // rand() random nilai 1-1000



    $sql = " select * from buku where kode_buku = '$kode_buku' ";
    $query = mysqli_query($connect,$sql);
    $hasil = mysqli_fetch_array($query);

    if (file_exists("image/".$hasil["image"])) {
      unlink("image/".$hasil["image"]);
      // menghapus gambar yang terdahulu
    }

    // upload gambarnya
    move_uploaded_file($_FILES["image"]["tmp_name"], "image/$filename");
    // sintak untuk update
    $sql =" update buku set judul = '$judul', penulis = '$penulis', tahun =
    '$tahun',harga = '$harga', stok = '$stok', image='$filename' where kode_buku = '$kode_buku' ";
  }

    else {
      $sql = " update buku set judul = '$judul', penulis = '$penulis', tahun =
      '$tahun',harga = '$harga', stok = '$stok' where kode_buku = '$kode_buku' ";
    }
    mysqli_query($connect, $sql);
  }
    header("location:buku.php");

}

if (isset($_GET["hapus"])){
  $kode_buku = $_GET["kode_buku"];
  $sql ="select * from buku where kode_buku ='$kode_buku'";
  $query = mysqli_query($connect,$sql);
  $hasil = mysqli_fetch_array($query);
  if (file_exists("image/".$hasil["image"])) {
    unlink("image/".$hasil["image"]);
  }
  $sql = "delete from buku where kode_buku='$kode_buku'";


  mysqli_query($connect, $sql);

  // direct ke halaman data siswa
  header("location:buku.php");
}
 ?>
