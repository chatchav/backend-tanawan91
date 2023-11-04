<?php
    include_once("../includes/function-db.php");
    
    $flag = $_POST["flagAction"];
    $aboutId = (isset($_POST["aboutId"]) ? $_POST["aboutId"] : "");

    switch ($flag) {
        case "add":
            $seq = getSeq('home_about');
            $chkdup = chkDup("select aboutId from home_about where status = 'A' and aboutId = '".$aboutId."'");
            if( $chkdup > 0){
                echo "This about already exists.";
            }else{
                $res = sql_query("
                    insert into home_about(
                        aboutId,
                        status,
                        createDate,
                        seq
                    )values(
                        '".$aboutId."',
                        'A',
                        NOW(),
                        '".$seq."'
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
          case "sortup":
            $id = $_POST["id"];
            $res = sql_query("
                select seq, DownID, DownSorterIndex, UpID, UpSorterIndex 
                from( 
                    SELECT aboutId , seq, 
                        lead(aboutId ) over(order by seq asc) DownID, 
                        lag(aboutId ) over(order by seq asc) UpID, 
                        lead(seq) over(order by seq asc) DownSorterIndex, 
                        lag(seq) over(order by seq asc) UpSorterIndex 
                    FROM home_about 
                    where status = 'A' 
                ) a 
                where aboutId = '".$id."' 
            ");
            while ($row = mysqli_fetch_row($res)) {
                $upSeq = $row[4];
                $upId = $row[3];
                $seq = $row[0];
                $res1 = sql_query("update home_about set seq = '".$upSeq."' where aboutId = '".$id."'");
                $res2 = sql_query("update home_about set seq = '".$seq."' where aboutId = '".$upId."'");
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
                    FROM home_about 
                    where Status = 'A' 
                ) a 
                where aboutId = '".$id."' 
            ");
            while ($row = mysqli_fetch_row($res)) {
                $downSeq = $row[2];
                $downId = $row[1];
                $seq = $row[0];
                $res1 = sql_query("update home_about set seq = '".$downSeq."' where aboutId = '".$id."'");
                $res2 = sql_query("update home_about set seq = '".$seq."' where aboutId = '".$downId."'");
            }
            echo "Success";
          break;
    }

?>