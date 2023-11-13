<?php
    include_once("../includes/function-db.php");
    
    $flag = $_POST["flagAction"];
    $title = (isset($_POST["title"]) ? $_POST["title"] : "");
    $title_th = (isset($_POST["title_th"]) ? $_POST["title_th"] : "");
    $urlFriendly = "";
    if($title != ""){
        $urlFriendly = str_replace(" ","-",strtolower($title)); 
    }

    switch ($flag) {
        case "add":
            $title = mysqli_real_escape_string($con, $title);
            $title_th = mysqli_real_escape_string($con, $title_th);
            
            $chkdup = chkDup("select statusId from setting_project_status where statusName = '".$title."'");
            if( $chkdup > 0){
                echo "This type already exists.";
            }else{
                $res = sql_query("
                    insert into setting_project_status(
                        statusName, statusNameTH, status
                    )values(
                        '".$title."', '".$title_th."', 'A'
                    )
                ");
                echo "Success";
            }
            
            break;
        case "update":
            $id = $_POST["id"];
            $title = mysqli_real_escape_string($con, $title);
            $title_th = mysqli_real_escape_string($con, $title_th);
            
            $chkdup = chkDup("select statusId from setting_project_status where statusName = '".$title."' and statusId != '".$id."'");
            if( $chkdup > 0){
                echo "This type already exists.";
            }else{
                $res = sql_query("
                    update setting_project_status
                    set 
                        statusName = '".$title."',
                        statusNameTH = '".$title_th."'
                    where statusId = '".$id."'
                ");
                echo "Success";
            }
            
            break;
        case "edit":
            $id = $_POST["id"];
            $data = getRowsData("select statusId, statusName, statusNameTH from setting_project_status where status = 'A' and statusId = '".$id."'");
            echo json_encode($data);
          break;
        case "del":
            $id = $_POST["id"];
            $res = sql_query("
                update setting_project_status
                set status = 'D'
                where statusId = '".$id."'
            ");
            echo "Success";
          break;
        default:
            $data = getRowsData("select statusId, statusName, CreateDate from setting_project_status where status = 'A'");
            echo json_encode($data);
      }

?>