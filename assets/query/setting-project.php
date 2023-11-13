<?php
    include_once("../includes/function-db.php");
    
    $flag = $_POST["flagAction"];
    $title = (isset($_POST["title"]) ? $_POST["title"] : "");
    $title_th = (isset($_POST["title_th"]) ? $_POST["title_th"] : "");
    $page = (isset($_POST["page"]) ? $_POST["page"] : "");

    

    switch ($flag) {
        case "update":
            $title = mysqli_real_escape_string($con, $title);
            $title_th = mysqli_real_escape_string($con, $title_th);
            
            $chk = chkDup("select page from setting_website where page = '".$page."'");
            if( $chk > 0){
                $res = sql_query("
                    update setting_website
                    set 
                        title = '".$title."', 
                        title_th = '".$title_th."'
                    where page = '".$page."'
                ");
            }else{
                $res = sql_query("
                    insert into setting_website(
                        title, 
                        title_th,
                        page
                    )values(
                        '".$title."', 
                        '".$title_th."',
                        '".$page."'
                    )
                ");
            }
            
            echo "Success";
        break;
    }

?>