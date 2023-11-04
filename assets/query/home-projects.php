<?php
    include_once("../includes/function-db.php");
    
    $flag = $_POST["flagAction"];
    $projectId = (isset($_POST["projectId"]) ? $_POST["projectId"] : "");

    switch ($flag) {
        case "add":
            $seq = getSeq('home_projects');
            $chkdup = chkDup("select projectId from home_projects where status = 'A' and projectId = '".$projectId."'");
            if( $chkdup > 0){
                echo "This project already exists.";
            }else{
                $res = sql_query("
                    insert into home_projects(
                        projectId,
                        status,
                        createDate,
                        seq
                    )values(
                        '".$projectId."',
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
          case "sortup":
            $id = $_POST["id"];
            $res = sql_query("
                select seq, DownID, DownSorterIndex, UpID, UpSorterIndex 
                from( 
                    SELECT projectId , seq, 
                        lead(projectId ) over(order by seq asc) DownID, 
                        lag(projectId ) over(order by seq asc) UpID, 
                        lead(seq) over(order by seq asc) DownSorterIndex, 
                        lag(seq) over(order by seq asc) UpSorterIndex 
                    FROM home_projects 
                    where Status = 'A' 
                ) a 
                where projectId = '".$id."' 
            ");
            while ($row = mysqli_fetch_row($res)) {
                $upSeq = $row[4];
                $upId = $row[3];
                $seq = $row[0];
                $res1 = sql_query("update home_projects set seq = '".$upSeq."' where projectId = '".$id."'");
                $res2 = sql_query("update home_projects set seq = '".$seq."' where projectId = '".$upId."'");
            }
            echo "Success";
        break;
        case "sortdown":
            $id = $_POST["id"];
            $res = sql_query("
                select seq, DownID, DownSorterIndex, UpID, UpSorterIndex 
                from( 
                    SELECT projectId , seq, 
                        lead(projectId ) over(order by seq asc) DownID, 
                        lag(projectId ) over(order by seq asc) UpID, 
                        lead(seq) over(order by seq asc) DownSorterIndex, 
                        lag(seq) over(order by seq asc) UpSorterIndex 
                    FROM home_projects 
                    where Status = 'A' 
                ) a 
                where projectId = '".$id."' 
            ");
            while ($row = mysqli_fetch_row($res)) {
                $downSeq = $row[2];
                $downId = $row[1];
                $seq = $row[0];
                $res1 = sql_query("update home_projects set seq = '".$downSeq."' where projectId = '".$id."'");
                $res2 = sql_query("update home_projects set seq = '".$seq."' where projectId = '".$downId."'");
            }
            echo "Success";
          break;
    }

?>