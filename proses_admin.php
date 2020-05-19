<?php
    include("config.php");
    if (isset($_POST["save_admin"])) {
        $action = $_POST["action"];
        $id_admin = $_POST["id_admin"];
        $nama = $_POST["nama"];
        $kontak = $_POST["kontak"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        if ($action == "insert") {
            $sql = "insert into admin values ('$id_admin','$nama', '$kontak', '$username', '$password')";
            mysqli_query($connect, $sql);

        }elseif ($action == "update") {
            $sql = "update admin set id_admin='$id_admin',
                    nama='$nama', kontak='$kontak',
                    username='$username', password='$password'";

            $query = mysqli_query($connect, $sql);
        }

        header("location:admin.php");
    }

    if (isset($_GET["hapus"])) {
        include("config.php");
        $id_admin = $_GET["id_admin"];
        // process delete
        $sql = "select * from admin where id_admin='$id_admin'";
        $query = mysqli_query($connect, $sql);

        $sql = "delete from admin where id_admin='$id_admin'";
        $query = mysqli_query($connect, $sql);

        header("location:admin.php");
    }
 ?>
