<?php
    include_once("../includes/function-db.php");
    
    $flag = $_POST["flagAction"];
    $imgOld = (isset($_POST["img-old"]) ? $_POST["img-old"] : "");

    $imgName = $imgOld;
    if(!empty($_FILES["image"]["name"])){
        $imgName = uploagImg($_FILES["image"],$imgOld);
    }

    

    switch ($flag) {
        case "add":
            
            $res = sql_query("
                insert into homeslider(
                    image,
                    status,
                    createDate
                )values(
                    '".$imgName."',
                    'A',
                    NOW()
                )
            ");
            echo "Success";
            
            break;
        case "update":
            $id = $_POST["id"];
            $res = sql_query("
                update homeslider
                set 
                    image = '".$imgName."'
                where sliderId = '".$id."'
            ");
            echo "Success";
            
            break;
        case "edit":
            $id = $_POST["id"];
            $data = getRowsData("select image from homeslider where status = 'A' and sliderId = '".$id."'");
            echo json_encode($data);
          break;
        case "del":
            $id = $_POST["id"];
            $res = sql_query("
                update homeslider
                set status = 'D'
                where sliderId = '".$id."'
            ");
            echo "Success";
          break;
        default:
            $data = getRowsData("select statusId, statusName, CreateDate from setting_project_status where status = 'A'");
            echo json_encode($data);
    }

?>