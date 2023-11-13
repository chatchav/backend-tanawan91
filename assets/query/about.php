<?php
    include_once("../includes/function-db.php");
    
    $flag = $_POST["flagAction"];
    $title = (isset($_POST["title"]) ? $_POST["title"] : "");
    $keyword = (isset($_POST["keyword"]) ? $_POST["keyword"] : "");
    $desc = (isset($_POST["desc"]) ? $_POST["desc"] : "");
    $imgOld = (isset($_POST["img-old"]) ? $_POST["img-old"] : "");
    //$title_th = (isset($_POST["title_th"]) ? $_POST["title_th"] : "");
    $urlFriendly = "";
    if($title != ""){
        $urlFriendly = str_replace(" ","-",str_replace("'","",strtolower($title))); 
    }
    $lang ="";
    if($_SESSION["lang"] != "EN"){
        $lang = "_th";
    }

    // echo "<pre>";
    // print_r($_POST);
    // print_r($_FILES);
    // print_r(GUID());
    // echo "</pre>";
    $imgName = $imgOld;
    if(!empty($_FILES["image"]["name"])){
        $imgName = uploagImg($_FILES["image"],$imgOld);
    }

    

    switch ($flag) {
        case "add":
            $seq = getSeq('about');
            $title = mysqli_real_escape_string($con, $title);
            $desc = mysqli_real_escape_string($con, $desc);
            sql_query("
                insert into about".$lang."(
                    image, 
                    title, 
                    urlFriendly, 
                    metaKeyword, 
                    description, 
                    status,
                    createDate,
                    seq
                )values(
                    '".$imgName."', 
                    '".$title."', 
                    '".$urlFriendly."',
                    '".$keyword."',
                    '".$desc."',
                    'A',
                    NOW(),
                    '".$seq."'
                )
            ");

            if($lang == ""){
                sql_query("
                    insert into about_th(
                        image, 
                        title, 
                        urlFriendly, 
                        metaKeyword, 
                        description, 
                        status,
                        createDate,
                        seq
                    )values(
                        '".$imgName."', 
                        '".$title."', 
                        '".$urlFriendly."',
                        '".$keyword."',
                        '".$desc."',
                        'A',
                        NOW(),
                        '".$seq."'
                    )
                ");
            }
            echo "Success";
            
            break;
        case "update":
            $id = $_POST["id"];
            $title = mysqli_real_escape_string($con, $title);
            $desc = mysqli_real_escape_string($con, $desc);
            $res = sql_query("
                update about".$lang."
                set 
                    title = '".$title."',
                    metaKeyword = '".$keyword."', 
                    description = '".$desc."'
                where aboutId = '".$id."'
            ");

            $res1 = sql_query("update about set image = '".$imgName."' where aboutId = '".$id."'");
            $res2 = sql_query("update about_th set image = '".$imgName."' where aboutId = '".$id."'");
            echo "Success";
            
            break;
        case "edit":
            $id = $_POST["id"];
            $data = getRowsData("select image, title, metaKeyword, description from about".$lang." where status = 'A' and aboutId = '".$id."'");
            echo json_encode($data);
          break;
        case "del":
            $id = $_POST["id"];
            $res = sql_query("
                update about
                set status = 'D'
                where aboutId = '".$id."'
            ");
            $res = sql_query("
                update about_th
                set status = 'D'
                where aboutId = '".$id."'
            ");
            echo "Success";
          break;
          case "sortup":
            $id = $_POST["id"];
            $res = sql_query("
                select seq, DownID, DownSorterIndex, UpID, UpSorterIndex 
                from( 
                    SELECT aboutId , seq, 
                        lead(aboutId) over(order by seq asc) DownID, 
                        lag(aboutId) over(order by seq asc) UpID, 
                        lead(seq) over(order by seq asc) DownSorterIndex, 
                        lag(seq) over(order by seq asc) UpSorterIndex 
                    FROM about 
                    where Status = 'A' 
                ) a 
                where aboutId = '".$id."' 
            ");
            while ($row = mysqli_fetch_row($res)) {
                $upSeq = $row[4];
                $upId = $row[3];
                $seq = $row[0];
                $res1 = sql_query("update about set seq = '".$upSeq."' where aboutId = '".$id."'");
                $res2 = sql_query("update about set seq = '".$seq."' where aboutId = '".$upId."'");

                $res1 = sql_query("update about_th set seq = '".$upSeq."' where aboutId = '".$id."'");
                $res2 = sql_query("update about_th set seq = '".$seq."' where aboutId = '".$upId."'");
            }
            echo "Success";
        break;
        case "sortdown":
            $id = $_POST["id"];
            $res = sql_query("
                select seq, DownID, DownSorterIndex, UpID, UpSorterIndex 
                from( 
                    SELECT aboutId , seq, 
                        lead(aboutId) over(order by seq asc) DownID, 
                        lag(aboutId) over(order by seq asc) UpID, 
                        lead(seq) over(order by seq asc) DownSorterIndex, 
                        lag(seq) over(order by seq asc) UpSorterIndex 
                    FROM about 
                    where Status = 'A'
                ) a 
                where aboutId = '".$id."' 
            ");
            while ($row = mysqli_fetch_row($res)) {
                $downSeq = $row[2];
                $downId = $row[1];
                $seq = $row[0];
                $res1 = sql_query("update about set seq = '".$downSeq."' where aboutId = '".$id."'");
                $res2 = sql_query("update about set seq = '".$seq."' where aboutId = '".$downId."'");

                $res1 = sql_query("update about_th set seq = '".$downSeq."' where aboutId = '".$id."'");
                $res2 = sql_query("update about_th set seq = '".$seq."' where aboutId = '".$downId."'");
            }
            echo "Success";
          break;
        default:
            $data = getRowsData("select statusId, statusName, CreateDate from setting_project_status where status = 'A'");
            echo json_encode($data);
    }

?>