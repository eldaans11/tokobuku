<?php
session_start();
if (!isset($_SESSION["id_customer"])) {
  header("location:login_customer.php");
}
include("config.php");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>daftar buku</title>
     <link rel="stylesheet" href="assets/css/bootstrap.min.css">
     <script src="assets/js/jquery.min.js"></script>
     <script src="assets/js/popper.min.js"></script>
     <script src="assets/js/bootstrap.min.js"></script>
     <script type="text/javascript">
       Detail = (item) =>{
         document.getElementById('kode_buku').value = item.kode_buku;
         document.getElementById('judul').innerHTML = item.judul;
         document.getElementById('penulis').innerHTML = item.penulis;
         document.getElementById('harga').innerHTML = item.harga;
         document.getElementById('stok').innerHTML = item.stok;
         document.getElementById('jumlah_beli').value = "1";
         document.getElementById("jumlah_beli").max = item.stok;

         document.getElementById("image").src = "image/" + item.image;
       }
     </script>
     <style>
     </style>
   </head>
   <body>
     <nav class="navbar navbar-expand-md bg-danger navbar-dark stiky-top">
      <a href="#">
        <img src="buku.png" width="100" alt=""> 
      </a>

      <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="menu">
        <span class="navbar navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav">
          <li class="nav-item"> <a href="list_buku.php" class="nav-link">Menu</a></li>
          <li class="nav-item"> <a href="buku.php" class="nav-link">Buku</a></li>
          <li class="nav-item"> <a href="customer.php" class="nav-link">Customer</a></li>
          <li class="nav-item">
            <a href="cart.php" class="nav-link">
              Cart(<?php echo count($_SESSION["cart"]); ?>)
            </a>

          </li>
          <li class="nav-item"> <a href="login_customer.php" class="nav-link">Logout</a></li>
        </ul>
      </div>
      </nav>


     <div class="container">
       <form action="list_buku.php" method="post">
         <input type="text" name="cari"
         class="form-control" placeholder="pencarian...">
       </form>
       <?php
     // membuat perintah sql utk menampilkan data siswa
     if (isset($_POST["cari"])) {
       // query jikka pencarian
       $cari = $_POST["cari"];
       $sql = " select * from buku where kode_buku like '%$cari%' or judul like '%$cari%'
       or penulis like '%$cari%' or tahun like '%$cari%' or harga like '%$cari%' or stok like '%$cari%'";
     }else {
       // query jika tidak mencari
       $sql = " select * from buku";
     }
     // eksekusi perintah sql nya
     $query = mysqli_query($connect, $sql);
   ?>

      <div class="row">
        <?php foreach ($query as $buku ): ?>
          <div class="card col-4">
            <div class="card-body">
              <img src="image/<?php echo $buku["image"]; ?>" width="100">
              <h5 class="text-success"><?php echo $buku["judul"]; ?></h5>
              <h6 class="text-secondary">Rp <?php echo $buku["harga"]; ?></h6>
            </div>
            <div class="card-footer">
              <button type="button" class="btn btn-sm btn-info" onclick= 'Detail(<?php echo json_encode($buku); ?>)'
                data-toggle='modal' data-target="#modal_detail">
                Detail
              </button>

            </div>
          </div>
       <?php endforeach; ?>
      </div>
      <div class="modal" id="modal_detail">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-danger">
              <h4 class="text-white">Detail Buku</h4>
            </div>
            <!-- untuk image -->
            <div class="modal-body">
              <div class="row">
                <div class="col-6">
                  <img style="width:100%"; height="auto"; id="image">
                </div>
                <div class="col-6">
                 <!-- deskripsi -->
                 <h4 id="judul"></h4>
                 <h4 id="penulis"></h4>
                 <h4 id="tahun"></h4>
                 <h4 id="harga"></h4>
                 <h4 id="stok"></h4>

                 <form action="proses_cart.php" method="post">
                   <input type="hidden" name="kode_buku" id="kode_buku">
                   Jumlah beli
                   <input type="number" name="jumlah_beli" id="jumlah_beli"
                   class="form-control" min="1">
                   <br>
                   <button type="submit" name="add_to_cart" class="btn btn-success">
                   Tambah Ke Keranjang</button>
                 </form>
               </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
     </div>
   </body>
</html>
