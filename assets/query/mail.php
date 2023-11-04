<?php
    include_once("../includes/function-db.php");
    
    $flag = $_POST["flagAction"];
    $title = (isset($_POST["title"]) ? $_POST["title"] : "");

    switch ($flag) {
        case "add":
            $chkdup = chkDup("select id from setting_mail where email = '".$title."'");
            if( $chkdup > 0){
                echo "This type already exists.";
            }else{
                $res = sql_query("
                    insert into setting_mail(
                        email, status
                    )values(
                        '".$title."', 'A'
                    )
                ");
                echo "Success";
            }
            
            break;
        case "update":
            $id = $_POST["id"];
            $chkdup = chkDup("select id from setting_mail where email = '".$title."' and id != '".$id."'");
            if( $chkdup > 0){
                echo "This type already exists.";
            }else{
                $res = sql_query("
                    update setting_mail
                    set email = '".$title."'
                    where id = '".$id."'
                ");
                echo "Success";
            }
            
            break;
        case "edit":
            $id = $_POST["id"];
            $data = getRowsData("select id, email from setting_mail where status = 'A' and id = '".$id."'");
            echo json_encode($data);
          break;
        case "del":
            $id = $_POST["id"];
            $res = sql_query("
                update setting_mail
                set status = 'D'
                where id = '".$id."'
            ");
            echo "Success";
          break;
        default:
            $data = getRowsData("select typeId, typeName, CreateDate from setting_project_type where status = 'A'");
            echo json_encode($data);
      }

?>