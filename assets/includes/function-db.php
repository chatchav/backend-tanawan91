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

    function uploagImg($files, $oldFile = "", $index = ""){
        
        $dir = "../img/user-upload/";
        if($index != ""){
            $fileName = $files["name"][$index];
            $fileTemp = $files["tmp_name"][$index];
        }else{
            $fileName = $files["name"];
            $fileTemp = $files["tmp_name"];
        }

        if($oldFile != "" && file_exists($dir.$oldFile)){
            unlink($dir.$oldFile);    
        }
        $ext = pathinfo($fileName, PATHINFO_EXTENSION );
        $webpImagePath = GUID().".".$ext;
        move_uploaded_file($fileTemp,$dir.$webpImagePath);
        return $webpImagePath;
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