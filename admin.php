<?php
session_start();
if (!isset($_SESSION["id_admin"])) {
  header("location:login_admin.php");

}
// kita akan memanggil config.php
// agar tidak prlu membuat koneksi baru

include("config.php");
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Toko Buku</title>
     <link rel="stylesheet" href="assets/css/bootstrap.css">
     <script src="assets/js/jquery.min.js"></script>
     <script src="assets/js/bootstrap.min.js"></script>
     <script src="assets/js/popper.min.js"></script>
     <script type="text/javascript">
       Add = () => {
         document.getElementById('action').value = "insert";
         document.getElementById('id_admin').value = "" ;
         document.getElementById('nama').value = ""
         document.getElementById('kontak').value = "";
         document.getElementById('username').value = "";
         document.getElementById('password').value = "";
       }

       Edit = (item) => {
         document.getElementById('action').value = "update";
         document.getElementById('id_admin').value = item.id_admin;
         document.getElementById('nama').value = item.nama; // lanjutkan
         document.getElementById('kontak').value = item.kontak;
         document.getElementById('username').value = item.username;
         document.getElementById('password').value = item.password;
       }
     </script>
   </head>
   <body>
     <?php
     if (isset($_POST ["cari"])) {
       // querry jika Pencarian
       $cari = $_POST ["cari"];
       $sql = "select * from admin where id_admin like '%$cari%' or nama like '%$cari%' or kontak like '%$cari%' or username like '%$cari%'
       or password like '%$cari%'";
     }else {
         // querry jika tidak mencari
         $sql = "select * from admin";

       // code...
     }


      // membuat perintah sql untuk menampilkan data siswa

     // eksekusi perintah-sqlnya
     $squery = mysqli_query($connect,$sql);
     ?>
     <div class="container">
        <div class="card">
              <nav class="navbar navbar-expand-md bg-danger navbar-dark">

               <div class="collapse navbar-collapse" id="menu">
                 <ul class="navbar-nav">
                   <li class="nav-item"> <a href="admin.php" class="nav-link">admin</a></li>
                   <li class="nav-item"> <a href="buku.php" class="nav-link">buku</a></li>
                   </a>
                 </li>
                 <li class="nav-item"> <a href="login_admin.php" class="nav-link">Logout</a></li>
                 </li>
                 </ul>
                 </div
         <div class="card-header bg-danger text-white">
           <h4>admin</h4>
         </div>
         <div class="card-body">
           <form  action="admin.php" method="post">
             <input type="text" name="cari"
             class="form-control" placeholder="Pencarian. . .">

           </form>
                <!-- Menampilkan data berupa tabel -->
                 <table class="table" border="1">
                   <thead>
                     <tr>
                       <th>Id_admin</th>
                       <th>nama</th>
                       <th>kontak</th>
                       <th>username</th>
                       <th>password</th>
                       <th>option</th>
                     </tr>
                   </thead>
                   <tbody>
                     <?php foreach ($squery as $admin): ?>
                       <tr>
                         <td><?php echo $admin["id_admin"]; ?></td>
                         <td><?php echo $admin["nama"]; ?></td>
                         <td><?php echo $admin["kontak"]; ?></td>
                         <td><?php echo $admin["username"]; ?></td>
                         <td><?php echo $admin["password"]; ?></td>
                         <td>
                           <button data-toggle="modal" data-target="#modal_admin"
                            type="button" class="btn btn-sm btn-info"
                            onclick='Edit(<?php echo json_encode($admin) ?>)'>
                             Edit
                           </button>
                           <a href="proses_admin.php?hapus=true&id_admin=<?php
                           echo $admin["id_admin"];  ?>"
                           onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                           <button type="button" class="btn btn-sm btn-danger">
                             Hapus
                           </button> </a>
                         </td>
                       </tr>
                     <?php  endforeach; ?>
                   </tbody>
                 </table>
                 <button data-toggle="modal" data-target="#modal_admin"
                  type="button" class="btn btn-sm btn-success" onclick="Add()">
                   Tambah Data
                 </button>
         </div>
       </div>
       <!-- end card .-->

       <!-- form modal -->
       <div class="modal fade" id="modal_admin">
         <div class="modal-dialog">
           <div class="modal-content">
             <form action="proses_admin.php" method="post"
                enctype="multipart/form-data">
               <div class="modal-header bg-danger text-black">
                 <h4>Form Toko Buku</h4>
               </div>
               <div class="modal-body">
                 <input type="hidden" name="action" id="action" >
                 id_admin
                 <input type="number" name="id_admin" id="id_admin"
                 class="form-control" required/>
                 nama
                 <input type="text" name="nama" id="nama"
                 class="form-control" required />
                 kontak
                 <input type="text" name="kontak" id="kontak" class="form-control">
                 username
                 <input type="text" name="username" id="username" class="form-control">
                password
                 <input type="text" name="password" id="password" class="form-control">
               </div>
               <div class="modal-footer">
                 <button type="submit" name="save_admin" class="btn btn-danger">
                 Simpan
               </button>

               </div>
             </form>
           </div>
         </div>
       </div>
       <!-- end form modal -->


   </body>
 </html>
