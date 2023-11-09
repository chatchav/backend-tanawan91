<?php
    @session_start();
    include_once("../includes/connect-db.php");
    function sql_query($query){
        global $con;
        $result = mysqli_query($con, $query);
        return $result;
    }

    function query_insert($query){
        global $con;
        if (mysqli_query($con, $query)) {
            $last_id = mysqli_insert_id($con);
            return $last_id;
        } else {
            return "Error: " . $query . "<br>" . mysqli_error($con);
        }
    }

    function getSeq($tableName){
        global $con;
        $result = mysqli_query($con, "SELECT MAX(seq+1) as seq FROM ".$tableName."");
        $row = mysqli_fetch_assoc($result);
        return $row["seq"];
    }

    function GUID(){
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    function resize_image($file, $w, $h, $crop=FALSE) {
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width-($width*abs($r-$w/$h)));
            } else {
                $height = ceil($height-($height*abs($r-$w/$h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w/$h > $r) {
                $newwidth = $h*$r;
                $newheight = $h;
            } else {
                $newheight = $w/$r;
                $newwidth = $w;
            }
        }
        $src = imagecreatefromjpeg($file);
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    
        return $dst;
    }

    function uploagImg($files, $oldFile = "", $index = ""){
        
        $dir = "../img/user-upload/";
        if($index != ""){
            $fileName = $files["name"][$index];
            $fileTemp = $files["tmp_name"][$index];
        }else{
            $fileName = $files["name"];
            $fileTemp = $files["tmp_name"];
        }
        list($width, $height) = getimagesize($fileTemp);
        
        $newWidth = 200;
        $newHeight = round($width*($newWidth*1.0)) / $height;
   
        if($oldFile != "" && file_exists($dir.$oldFile)){
            unlink($dir.$oldFile);    
        }
        $ext = pathinfo($fileName, PATHINFO_EXTENSION );
        $genName = GUID();
        $webpImagePath = $genName.".".$ext;
        $webpPath = $genName.".webp";
        move_uploaded_file($fileTemp,$dir.$webpImagePath);
        // $img = resize_image($dir.$webpImagePath, $newWidth, $newHeight);
        // imagejpeg($img, $dir."output.".$ext);
        
        if($ext != "webp"){
            if($ext == "png"){
                $image = imagecreatefrompng($dir.$webpImagePath);
            }else{
                $image = imagecreatefromjpeg($dir.$webpImagePath);
            }
    
            if ($image) {
                imagewebp($image, $dir.$webpPath);
                imagedestroy($image);
                unlink($dir.$webpImagePath); 
            } else {
                echo 'Failed to load image.';
            }
        }
        
        return $webpPath;
    }

    function chkDup($query){
        global $con;
        $result = mysqli_query($con, $query);
        $n_rows = mysqli_num_rows($result);
        return $n_rows;
    }

    function getRowsData($query){
        global $con;
        $rows = [];
        $result = mysqli_query($con, $query);
        $n_rows = mysqli_num_rows($result);
        if($n_rows > 0){
            while ($row = mysqli_fetch_row($result)) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    
?>