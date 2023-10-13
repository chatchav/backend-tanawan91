<?php
    include_once("../includes/function-db.php");
    
    $flag = $_POST["flagAction"];
    $aboutId = (isset($_POST["aboutId"]) ? $_POST["aboutId"] : "");

    switch ($flag) {
        case "add":
            $chkdup = chkDup("select aboutId from home_about where status = 'A' and aboutId = '".$aboutId."'");
            if( $chkdup > 0){
                echo "This about already exists.";
            }else{
                $res = sql_query("
                    insert into home_about(
                        aboutId,
                        status,
                        createDate
                    )values(
                        '".$aboutId."',
                        'A',
                        NOW()
                    )
                ");
                echo "Success";
            }
            
            
            break;
        case "update":
            $id = $_POST["id"];
            $chkdup = chkDup("select aboutId from home_about where status = 'A' and aboutId = '".$aboutId."'");
            if( $chkdup > 0){
                echo "This about already exists.";
            }else{
                $res = sql_query("
                    update home_about
                    set 
                        aboutId = '".$aboutId."'
                    where aboutId = '".$id."' and status = 'A'
                ");
                echo "Success";
            }
            
            break;
        case "del":
            $res = sql_query("
                update home_about
                set status = 'D'
                where aboutId = '".$aboutId."'
            ");
            echo "Success";
          break;
    }

?>