<?php
    include_once("../includes/function-db.php");

    $flag = $_REQUEST["flagAction"];
    $imgOld = (isset($_POST["img-old"]) ? $_POST["img-old"] : "");

    $imgName = $imgOld;
    if(!empty($_FILES["image"]["name"])){
        $imgName = uploagImg($_FILES["image"],$imgOld);
    }

    

    switch ($flag) {
        case "add":
            $seq = getSeq('homeslider');
            $res = sql_query("
                insert into homeslider(
                    image,
                    status,
                    createDate,
                    seq
                )values(
                    '".$imgName."',
                    'A',
                    NOW(),
                    '".$seq."'
                )
            ");
            echo "Success";
            
            break;
        case "update":
            $id = $_POST["id"];
            $res = sql_query("
                update homeslider
                set 
                    image = '".$imgName."'
                where sliderId = '".$id."'
            ");
            echo "Success";
            
            break;
        case "edit":
            $id = $_POST["id"];
            $data = getRowsData("select image from homeslider where status = 'A' and sliderId = '".$id."'");
            echo json_encode($data);
          break;
        case "del":
            $id = $_POST["id"];
            $res = sql_query("
                update homeslider
                set status = 'D'
                where sliderId = '".$id."'
            ");
            echo "Success";
          break;
        case "sortup":
            $id = $_POST["id"];
            $res = sql_query("
                select seq, DownID, DownSorterIndex, UpID, UpSorterIndex 
                from( 
                    SELECT sliderId , seq, 
                        lead(sliderId ) over(order by seq asc) DownID, 
                        lag(sliderId ) over(order by seq asc) UpID, 
                        lead(seq) over(order by seq asc) DownSorterIndex, 
                        lag(seq) over(order by seq asc) UpSorterIndex 
                    FROM homeslider 
                    where Status = 'A' 
                ) a 
                where sliderId = '".$id."' 
            ");
            while ($row = mysqli_fetch_row($res)) {
                $upSeq = $row[4];
                $upId = $row[3];
                $seq = $row[0];
                $res1 = sql_query("update homeslider set seq = '".$upSeq."' where sliderId = '".$id."'");
                $res2 = sql_query("update homeslider set seq = '".$seq."' where sliderId = '".$upId."'");
            }
            echo "Success";
        break;
        case "sortdown":
            $id = $_POST["id"];
            $res = sql_query("
                select seq, DownID, DownSorterIndex, UpID, UpSorterIndex 
                from( 
                    SELECT sliderId , seq, 
                        lead(sliderId ) over(order by seq asc) DownID, 
                        lag(sliderId ) over(order by seq asc) UpID, 
                        lead(seq) over(order by seq asc) DownSorterIndex, 
                        lag(seq) over(order by seq asc) UpSorterIndex 
                    FROM homeslider 
                    where Status = 'A' 
                ) a 
                where sliderId = '".$id."' 
            ");
            while ($row = mysqli_fetch_row($res)) {
                $downSeq = $row[2];
                $downId = $row[1];
                $seq = $row[0];
                $res1 = sql_query("update homeslider set seq = '".$downSeq."' where sliderId = '".$id."'");
                $res2 = sql_query("update homeslider set seq = '".$seq."' where sliderId = '".$downId."'");
            }
            echo "Success";
          break;
        default:
            $data = getRowsData("select sliderId, image, CreateDate from homeslider where status = 'A' order by createDate desc");
            echo json_encode($data);
    }

?>