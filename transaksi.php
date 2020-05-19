<?php
session_start();
if (!isset($_SESSION["id_customer"])) {
  header("location:login_customer.php");
}
// memamnggil file config.php
// agar tidak perlu membuat koneksi baru
include("config.php");
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Toko Buku</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <link rel="stylesheet" href="">
    <script type="text/javascript">

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
         <li class="nav-item"> <a href="login_customer.php" class="nav-link">Logout</a></li>
       </ul>
     </div>
     </nav>

     <div class="container">
       <div class="card mt-3">
         <div class="card-header bg-dark">
           <h4 class="text-white">Riwayat Transaksi</h4>
         </div>
         <div class="card-body">
           <?php
           $sql = "select * from transaksi t inner join customer c
           on t.id_customer = c.id_customer
           where t.id_customer = '".$_SESSION["id_customer"]."' order by t.tgl desc";
           $query = mysqli_query($connect, $sql);
            ?>

            <ul class="list-group">
              <?php foreach ($query as $transaksi): ?>
                <li class="list-group-item mb-4">
                <h6>ID Transaksi: <?php echo $transaksi["id_transaksi"]; ?></h6>
                <h6>Nama Pembeli: <?php echo $transaksi["nama"]; ?></h6>
                <h6>Tgl. Transaksi: <?php echo $transaksi["tgl"]; ?></h6>
                <h6>List Barang: </h6>

                <?php
                $sql2 = "select * from detail_transaksi d inner join buku b
                on d.kode_buku = b.kode_buku
                where d.id_transaksi = '".$transaksi["id_transaksi"]."'";
                $query2 = mysqli_query($connect, $sql2);
                 ?>

                 <table class="table table-borderless">
                   <thead>
                     <tr>
                       <th>Judul</th>
                       <th>Jumlah</th>
                       <th>Harga</th>
                       <th>Total</th>
                     </tr>
                   </thead>
                   <tbody>
                     <?php $total = 0; foreach ($query2 as $detail): ?>
                       <tr>
                         <td><?php echo $detail["judul"] ?></td>
                         <td><?php echo $detail["jumlah"] ?></td>
                         <td>Rp <?php echo number_format($detail["harga_beli"]); ?></td>
                         <td>
                           Rp <?php echo number_format($detail["harga_beli"]*$detail["jumlah"]); ?>
                         </td>
                       </tr>
                     <?php $total += ($detail['harga_beli']*$detail["jumlah"]); endforeach; ?>
                   </tbody>
                 </table>
                 <h6 class="text-danger">Rp <?php echo number_format($total); ?></h6>
               </li>
              <?php endforeach; ?>
            </ul>
         </div>
       </div>
     </div>
     <br>
    <div class="footer" align="center">
        &copy; Copyright by daffa
    </div>
    <br>
  </body>
</html>
