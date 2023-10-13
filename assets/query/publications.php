<?php
    include_once("../includes/function-db.php");
    
    $flag = $_POST["flagAction"];
    $title = (isset($_POST["title"]) ? $_POST["title"] : "");
    $keyword = (isset($_POST["keyword"]) ? $_POST["keyword"] : "");
    $shortdesc = htmlspecialchars((isset($_POST["shortdesc"]) ? $_POST["shortdesc"] : ""), ENT_QUOTES);
    $desc = htmlspecialchars((isset($_POST["desc"]) ? $_POST["desc"] : ""), ENT_QUOTES);
    $imgOld = (isset($_POST["img-old"]) ? $_POST["img-old"] : "");
    //$title_th = (isset($_POST["title_th"]) ? $_POST["title_th"] : "");
    $urlFriendly = "";
    if($title != ""){
        $urlFriendly = str_replace(" ","-",strtolower($title)); 
    }
    $lang ="";
    if($_SESSION["lang"] != "EN"){
        $lang = "_th";
    }
    // echo "<pre>";
    // print_r($desc);
    // echo "</pre>";
    $imgName = $imgOld;
    if(!empty($_FILES["image"]["name"])){
        $imgName = uploagImg($_FILES["image"],$imgOld);
    }

    

    switch ($flag) {
        case "add":
            $res = sql_query("
                insert into publications".$lang."(
                    image, 
                    title, 
                    urlFriendly, 
                    keyword, 
                    description, 
                    shortDescription, 
                    status,
                    createDate
                )values(
                    '".$imgName."', 
                    '".$title."', 
                    '".$urlFriendly."',
                    '".$keyword."',
                    '".$desc."',
                    '".$shortdesc."',
                    'A',
                    NOW()
                )
            ");

            if($lang == ""){
                sql_query(
                "insert into publications_th(
                    image, 
                    title, 
                    urlFriendly, 
                    keyword, 
                    description, 
                    shortDescription, 
                    status,
                    createDate
                )values(
                    '".$imgName."', 
                    '".$title."', 
                    '".$urlFriendly."',
                    '".$keyword."',
                    '".$desc."',
                    '".$shortdesc."',
                    'A',
                    NOW()
                )
                ");
            }
            echo "Success";
            
            break;
        case "update":
            $id = $_POST["id"];
            $res = sql_query("
                update publications".$lang."
                set 
                    image = '".$imgName."', 
                    title = '".$title."',
                    keyword = '".$keyword."',
                    description = '".$desc."',
                    shortDescription = '".$shortdesc."'
                where publicId = '".$id."'
            ");
            echo "Success";
            
            break;
        case "edit":
            $id = $_POST["id"];
            $data = getRowsData("select image, title, keyword, shortDescription, description  from publications".$lang." where status = 'A' and publicId = '".$id."'");
            $data[0][3] = htmlspecialchars_decode($data[0][3]);
            $data[0][4] = htmlspecialchars_decode($data[0][4]);
            echo json_encode($data);
          break;
        case "del":
            $id = $_POST["id"];
            $res = sql_query("
                update publications
                set status = 'D'
                where publicId = '".$id."'
            ");
            $res = sql_query("
                update publications_th
                set status = 'D'
                where publicId = '".$id."'
            ");
            echo "Success";
          break;
        default:
            $data = getRowsData("select statusId, statusName, CreateDate from setting_project_status where status = 'A'");
            echo json_encode($data);
    }

?>