<?php
    include_once("../includes/function-db.php");
    
    $flag = $_POST["flagAction"];
    $projectId = (isset($_POST["projectId"]) ? $_POST["projectId"] : "");

    switch ($flag) {
        case "add":
            $chkdup = chkDup("select projectId from home_projects where status = 'A' and projectId = '".$projectId."'");
            if( $chkdup > 0){
                echo "This project already exists.";
            }else{
                $res = sql_query("
                    insert into home_projects(
                        projectId,
                        status,
                        createDate
                    )values(
                        '".$projectId."',
                        'A',
                        NOW()
                    )
                ");
                echo "Success";
            }
            
            break;
        case "update":
            $id = $_POST["id"];
            $chkdup = chkDup("select projectId from home_projects where status = 'A' and projectId = '".$projectId."'");
            if( $chkdup > 0){
                echo "This about already exists.";
            }else{
                $res = sql_query("
                    update home_projects
                    set 
                        projectId = '".$projectId."'
                    where projectId = '".$id."' and status = 'A'
                ");
                echo "Success";
            }
            
            break;
        case "del":
            $res = sql_query("
                update home_projects
                set status = 'D'
                where projectId = '".$projectId."'
            ");
            echo "Success";
          break;
    }

?>