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
            $chkdup = chkDup("select typeId from setting_project_type where urlFriendly = '".$urlFriendly."'");
            if( $chkdup > 0){
                echo "This type already exists.";
            }else{
                $res = sql_query("
                    insert into setting_project_type(
                        typeName, urlFriendly, status
                    )values(
                        '".$title."', '".$urlFriendly."', 'A'
                    )
                ");
                echo "Success";
            }
            
            break;
        case "update":
            $id = $_POST["id"];
            $chkdup = chkDup("select typeId from setting_project_type where urlFriendly = '".$urlFriendly."' and typeId != '".$id."'");
            if( $chkdup > 0){
                echo "This type already exists.";
            }else{
                $res = sql_query("
                    update setting_project_type
                    set 
                        typeName = '".$title."',
                        typeNameTH = '".$title_th."',
                        urlFriendly = '".$urlFriendly."'
                    where typeId = '".$id."'
                ");
                echo "Success";
            }
            
            break;
        case "edit":
            $id = $_POST["id"];
            $data = getRowsData("select typeId, typeName, typeNameTH from setting_project_type where status = 'A' and typeId = '".$id."'");
            echo json_encode($data);
          break;
        case "del":
            $id = $_POST["id"];
            $res = sql_query("
                update setting_project_type
                set status = 'D'
                where typeId = '".$id."'
            ");
            echo "Success";
          break;
        default:
            $data = getRowsData("select typeId, typeName, CreateDate from setting_project_type where status = 'A'");
            echo json_encode($data);
      }

?>