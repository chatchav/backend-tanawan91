<?php
    include_once("../includes/function-db.php");
    
    $flag = $_POST["flagAction"];
    $title = (isset($_POST["title"]) ? $_POST["title"] : "");
    $type = (isset($_POST["type"]) ? $_POST["type"] : "");
    $desc = (isset($_POST["desc"]) ? $_POST["desc"] : "");
    // $urlFriendly = "";
    // if($title != ""){
    //     $urlFriendly = str_replace(" ","-",strtolower($title)); 
    // }

    switch ($flag) {
        case "add":
        
                $res = sql_query("
                    insert into services(
                        title,
                        type,
                        description,
                        status
                    )values(
                        '".$title."', 
                        '".$type."', 
                        '".$desc."', 
                        'A'
                    )
                ");
                echo "Success";
            
            break;
        case "update":
            $id = $_POST["id"];
            $res = sql_query("
                update services
                set 
                    title = '".$title."',
                    type = '".$type."',
                    description = '".$desc."'
                where serviceId  = '".$id."'
            ");
            echo "Success";
            break;
        case "edit":
            $id = $_POST["id"];
            $data = getRowsData("select serviceId, title, type, description  from services where status = 'A' and serviceId = '".$id."'");
            echo json_encode($data);
          break;
        case "del":
            $id = $_POST["id"];
            $res = sql_query("
                update services
                set status = 'D'
                where serviceId = '".$id."'
            ");
            echo "Success";
          break;
        default:
            $data = getRowsData("select statusId, statusName, CreateDate from setting_project_status where status = 'A'");
            echo json_encode($data);
      }

?>