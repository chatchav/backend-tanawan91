<?php
    include_once("../includes/function-db.php");
    
    $flag = $_POST["flagAction"];
    $title = (isset($_POST["title"]) ? $_POST["title"] : "");
    $keyword = (isset($_POST["keyword"]) ? $_POST["keyword"] : "");
    $desc = (isset($_POST["desc"]) ? $_POST["desc"] : "");
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
    // print_r($_POST);
    // print_r($_FILES);
    // print_r(GUID());
    // echo "</pre>";
    $imgName = $imgOld;
    if(!empty($_FILES["image"]["name"])){
        $imgName = uploagImg($_FILES["image"],$imgOld);
    }

    

    switch ($flag) {
        case "add":
            
            sql_query("
                insert into about".$lang."(
                    image, 
                    title, 
                    urlFriendly, 
                    metaKeyword, 
                    description, 
                    status,
                    createDate
                )values(
                    '".$imgName."', 
                    '".$title."', 
                    '".$urlFriendly."',
                    '".$keyword."',
                    '".$desc."',
                    'A',
                    NOW()
                )
            ");

            if($lang == ""){
                sql_query("
                    insert into about_th(
                        image, 
                        title, 
                        urlFriendly, 
                        metaKeyword, 
                        description, 
                        status,
                        createDate
                    )values(
                        '".$imgName."', 
                        '".$title."', 
                        '".$urlFriendly."',
                        '".$keyword."',
                        '".$desc."',
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
                update about".$lang."
                set 
                    image = '".$imgName."', 
                    title = '".$title."',
                    metaKeyword = '".$keyword."', 
                    description = '".$desc."'
                where aboutId = '".$id."'
            ");
            echo "Success";
            
            break;
        case "edit":
            $id = $_POST["id"];
            $data = getRowsData("select image, title, metaKeyword, description from about".$lang." where status = 'A' and aboutId = '".$id."'");
            echo json_encode($data);
          break;
        case "del":
            $id = $_POST["id"];
            $res = sql_query("
                update about
                set status = 'D'
                where aboutId = '".$id."'
            ");
            $res = sql_query("
                update about_th
                set status = 'D'
                where aboutId = '".$id."'
            ");
            echo "Success";
          break;
        default:
            $data = getRowsData("select statusId, statusName, CreateDate from setting_project_status where status = 'A'");
            echo json_encode($data);
    }

?>