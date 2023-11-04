<?php
    include_once("../includes/function-db.php");
    
    $flag = $_POST["flagAction"];
    $mapurl = (isset($_POST["mapURL"]) ? $_POST["mapURL"] : "");
    $desc = (isset($_POST["desc"]) ? $_POST["desc"] : "");
    $imgOld = (isset($_POST["img-old"]) ? $_POST["img-old"] : "");

    // echo "<pre>";
    // print_r($_POST);
    // print_r($_FILES);
    // print_r(GUID());
    // echo "</pre>";
    $imgName = $imgOld;
    if(!empty($_FILES["image"]["name"])){
        $imgName = uploagImg($_FILES["image"],$imgOld);
    }

    $lang ="";
    if($_SESSION["lang"] != "EN"){
        $lang = "_th";
    }

    

    switch ($flag) {
        case "update":
            $chk = chkDup("select contactId from contact");
            if( $chk > 0){
                $res = sql_query("
                    update contact".$lang."
                    set 
                        image = '".$imgName."', 
                        mapURL = '".$mapurl."',
                        description = '".$desc."'
                ");
            }else{
                $res = sql_query("
                    insert into contact(
                        image, 
                        mapURL,
                        description
                    )values(
                        '".$imgName."', 
                        '".$mapurl."',
                        '".$desc."'
                    )
                ");

                $res = sql_query("
                    insert into contact_th(
                        image, 
                        mapURL,
                        description
                    )values(
                        '".$imgName."', 
                        '".$mapurl."',
                        '".$desc."'
                    )
                ");
            }
            
            echo "Success";
            
            break;
        case "edit":
            $id = $_POST["id"];
            $data = getRowsData("select contactId, image, mapURL, description from contact".$lang."");
            echo json_encode($data);
          break;
    }

?>