<?php
// include 'disperror.php';
session_start();
$rmbr=$_SESSION['%&%'];
$rmbr2=$_SESSION['%&%%'];

if(isset($rmbr2)){
    header('Location:dispusr.php');
    exit;
}
else if(!isset($_SESSION['%&%'])){
    header('Location:login.php');
    exit;
}

include 'connection.php';
$pilihan = "";

// untuk check apa ada inputan pilihan
if (isset($_GET['pilihan']) && $_GET['pilihan'] != "") {
    $pilihan = $_GET['pilihan'];
}
// echo $rmbr;
$sql=mysqli_query($conn,"SELECT * FROM `users` WHERE `username`='$rmbr'");
$row=mysqli_fetch_assoc($sql);
$fn=$row['fullname'];
date_default_timezone_set('Asia/Jakarta');
$timestamp = date('h:i A d/m/Y');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#format'
        });
    </script>
    <style>
        input{
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <form action="" method="post">
        <button name="btn">Logout</button>
    </form>
    <?php
    if (isset($_POST['btn'])) {
        session_destroy();
        header('Refresh:0.1');
        exit;
    }?>
    <form action="" method="get">
        <select name="pilihan" id="pilihan">
            <option selected disabled value="">Select an Option</option>
            <option value="Video" <?php echo ($pilihan === "Video") ? "selected" : "" ?>>Video</option>
            <option value="Artikel" <?php echo ($pilihan === "Artikel") ? "selected" : "" ?>>Artikel</option>
        </select>
    </form>
    <div style="margin-bottom:10px;"></div>
    <?php if ($pilihan == "Video") { ?>
        <form action="uploadvid.php" method="post">
            <input type="hidden" name="pilihan" value="<?=$pilihan?>"><br>
            <input type="text" name="nama" placeholder="Masukan nama" autocomplete="off" id="" value="<?= $fn?>"><br>
            <input type="text" name="judul" placeholder="Masukan judul" id="" autocomplete="off"><br>
            <input type="file" name="video" id=""><br>
            <input type="submit" name="btnSubmit" value="Submit">
        </form>
        <?php
        if (isset($_POST['btnSubmit'])) {
            $nama = (isset($_POST['nama'])) ? $_POST['nama'] : "";
            $judul = (isset($_POST['judul'])) ? $_POST['judul'] : "";
            $video = (isset($_POST['video'])) ? $_POST['video'] : "";
            
            $instvid = "INSERT INTO `FILES`(`author`,`judul`,`file_type_id`,`isi`,`created_at`) VALUES ('', '$judul','$pilihan','$isi','$timestamp')";

            echo $instvid;
            mysqli_query($conn, $instvid);
            
        }
        ?>
    <?php } ?>

    <?php if ($pilihan == "Artikel") { ?>
        <form action="" method="post">
            <input type="hidden" name="pilihan" value="<?=$pilihan?>"><br>
            <input type="text" name="nama2" id="" placeholder="Masukan nama" autocomplete="off" value="<?= $fn?>"><br>
            <input type="text" name="judul2" placeholder="masukan judul" id="" autocomplete="off"><br>
            <textarea style="width: 360px;" name="isi2" id="format" cols="30" rows="20"></textarea><br>
            <input type="submit" name="btnSubmit2" value="Submit">
        </form>
        <?php
            if (isset($_POST['btnSubmit2'])) {
                $nama2 = (isset($_POST['nama2'])) ? $_POST['nama2'] : "";
                $judul2 = (isset($_POST['judul2'])) ? $_POST['judul2'] : "";
                $isi2 = (isset($_POST['isi2'])) ? $_POST['isi2'] : "";            
                $instart = "INSERT INTO `FILES`(`author`,`judul`,`file_type_id`,`isi`,`created_at`) VALUES ('$nama2','$judul2','$pilihan','$isi2','$timestamp')";
                $insart=mysqli_query($conn, $instart);
                if ($insart) {
                    echo'<script>alert("Submit succes")</script>';
                }
                else {
                    echo'<script>alert("Submit succes")</script>';
                }
            }
        ?>
    <?php } ?>
    
    <script>
        var pilihan = document.getElementById('pilihan');

        
    </script>
</body>

</html>