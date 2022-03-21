<?php
    include 'connection.php';
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    date_default_timezone_set('Asia/Jakarta');
    $timestamp = date('d/m/Y h:i A');
    if (isset($_POST['btnSubmit'])&&isset($_FILES['my_video'])) {
        echo "<pre>";
        print_r($_FILES['my_video']);
        echo "</pre>";
        $fn = (isset($_POST['nama'])) ? $_POST['nama'] :"";
        $judul = (isset($_POST['judul'])) ? $_POST['judul'] :"";
        $videoname = $_FILES['my_video']['name'];
        $tmp_name = $_FILES['my_video']['tmp_name'];
        $error = $_FILES['my_video']['error'];

        if($error===0){
            $videoex=pathinfo($videoname,PATHINFO_EXTENSION);

            $video_ex_lc=strtolower($videoex);

            $allowed_exs=array("mp4", 'webm','avi','flv','mov');

            if(in_array($video_ex_lc, $allowed_exs)){
                $newvideoname = uniqid("video-",true).".".$video_ex_lc;
                $video_upload_path='uploads/'.$newvideoname;
                move_uploaded_file($tmp_name,$video_upload_path);
                // $sm="Upload Succes";
                // header("Location:index.php?sm=$sm");

                $sql="INSERT INTO `files`(
                    `author`,
                    `judul`,
                    `file_type_id`,
                    `isi`,
                    `created_at`
                )
                VALUES(
                    '$fn',
                    '$judul',
                    'video',
                    '$newvideoname',
                    '$timestamp'
                );";
                $run=mysqli_query($conn,$sql);
            }else{
                $em= "You can't upload this type of file";
                header("Location:index.php?error=$em");
            }
        }
}else{
    $er="There was an error occured";
    header('Location:index.php?error=$er');
}

?>
