<?php
    include_once("../includes/function-db.php");
    
    $flag = $_POST["flagAction"];
    $title = (isset($_POST["title"]) ? $_POST["title"] : "");
    $title_th = (isset($_POST["title_th"]) ? $_POST["title_th"] : "");
    $page = (isset($_POST["page"]) ? $_POST["page"] : "");

    $imgOld1 = (isset($_POST["img-old1"]) ? $_POST["img-old1"] : "");
    $imgOld2 = (isset($_POST["img-old2"]) ? $_POST["img-old2"] : "");
    $imgName1 = $imgOld1;
    $imgName2 = $imgOld2;
    if(!empty($_FILES["image1"]["name"])){
        $imgName1 = uploagImg($_FILES["image1"],$imgOld1);
    }
    if(!empty($_FILES["image2"]["name"])){
        $imgName2 = uploagImg($_FILES["image2"],$imgOld2);
    }
    

    switch ($flag) {
        case "update":
            $title = mysqli_real_escape_string($con, $title);
            $title_th = mysqli_real_escape_string($con, $title_th);
            
            $chk = chkDup("select page from setting_website where page = '".$page."'");
            if( $chk > 0){
                $res = sql_query("
                    update setting_website
                    set 
                        img1 = '".$imgName1."', 
                        img2 = '".$imgName2."'
                    where page = '".$page."'
                ");
            }else{
                $res = sql_query("
                    insert into setting_website(
                        img1, 
                        img2,
                        page
                    )values(
                        '".$imgName1."', 
                        '".$imgName2."',
                        '".$page."'
                    )
                ");
            }
            echo "Success";
        break;
    }

?>