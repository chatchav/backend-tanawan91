<?php
    include_once("../includes/function-db.php");
    
    $flag = $_POST["flagAction"];
    $title = (isset($_POST["title"]) ? $_POST["title"] : "");
    $type = (isset($_POST["type"]) ? $_POST["type"] : "");
    $desc = (isset($_POST["desc"]) ? $_POST["desc"] : "");
    // $urlFriendly = "";
    // if($title != ""){
    //     $urlFriendly = str_replace(" ","-",strtolower($title)); 
    // }
    $lang ="";
    if($_SESSION["lang"] != "EN"){
        $lang = "_th";
    }

    switch ($flag) {
        case "add":
                $seq = getSeq('services');
                $desc = mysqli_real_escape_string($con, $desc);
                $title = mysqli_real_escape_string($con, $title);
                $res = sql_query("
                    insert into services".$lang."(
                        title,
                        type,
                        description,
                        status,
                        seq
                    )values(
                        '".$title."', 
                        '".$type."', 
                        '".$desc."', 
                        'A',
                        '".$seq."'
                    )
                ");

                if($lang == ""){
                    sql_query("
                        insert into services_th(
                            title,
                            type,
                            description,
                            status,
                            seq
                        )values(
                            '".$title."', 
                            '".$type."', 
                            '".$desc."', 
                            'A',
                            '".$seq."'
                        )
                    ");
                }
                echo "Success";
            
            break;
        case "update":
            $id = $_POST["id"];
            $desc = mysqli_real_escape_string($con, $desc);
            $title = mysqli_real_escape_string($con, $title);
            $res = sql_query("
                update services".$lang."
                set 
                    title = '".$title."',
                    type = '".$type."',
                    description = '".$desc."'
                where serviceId  = '".$id."'
            ");
            echo "Success";
            break;
        case "edit":
            $id = $_POST["id"];
            $data = getRowsData("select serviceId, title, type, description  from services".$lang." where status = 'A' and serviceId = '".$id."'");
            echo json_encode($data);
          break;
        case "del":
            $id = $_POST["id"];
            $res = sql_query("
                update services
                set status = 'D'
                where serviceId = '".$id."'
            ");

            sql_query("
                update services_th
                set status = 'D'
                where serviceId = '".$id."'
            ");
            echo "Success";
          break;
        case "sortup":
            $id = $_POST["id"];
            $res = sql_query("
                select seq, DownID, DownSorterIndex, UpID, UpSorterIndex 
                from( 
                    SELECT serviceId , seq, 
                        lead(serviceId) over(order by seq asc) DownID, 
                        lag(serviceId) over(order by seq asc) UpID, 
                        lead(seq) over(order by seq asc) DownSorterIndex, 
                        lag(seq) over(order by seq asc) UpSorterIndex 
                    FROM services 
                    where Status = 'A' and Type = '". $type."'
                ) a 
                where serviceId = '".$id."' 
            ");
            while ($row = mysqli_fetch_row($res)) {
                $upSeq = $row[4];
                $upId = $row[3];
                $seq = $row[0];
                $res1 = sql_query("update services set seq = '".$upSeq."' where serviceId = '".$id."'");
                $res2 = sql_query("update services set seq = '".$seq."' where serviceId = '".$upId."'");

                $res1 = sql_query("update services_th set seq = '".$upSeq."' where serviceId = '".$id."'");
                $res2 = sql_query("update services_th set seq = '".$seq."' where serviceId = '".$upId."'");
            }
            echo "Success";
        break;
        case "sortdown":
            $id = $_POST["id"];
            $res = sql_query("
                select seq, DownID, DownSorterIndex, UpID, UpSorterIndex 
                from( 
                    SELECT serviceId , seq, 
                        lead(serviceId) over(order by seq asc) DownID, 
                        lag(serviceId) over(order by seq asc) UpID, 
                        lead(seq) over(order by seq asc) DownSorterIndex, 
                        lag(seq) over(order by seq asc) UpSorterIndex 
                    FROM services 
                    where Status = 'A' and Type = '". $type."'
                ) a 
                where serviceId = '".$id."' 
            ");
            while ($row = mysqli_fetch_row($res)) {
                $downSeq = $row[2];
                $downId = $row[1];
                $seq = $row[0];
                $res1 = sql_query("update services set seq = '".$downSeq."' where serviceId = '".$id."'");
                $res2 = sql_query("update services set seq = '".$seq."' where serviceId = '".$downId."'");

                $res1 = sql_query("update services_th set seq = '".$downSeq."' where serviceId = '".$id."'");
                $res2 = sql_query("update services_th set seq = '".$seq."' where serviceId = '".$downId."'");
            }
            echo "Success";
          break;
        default:
            $data = getRowsData("select statusId, statusName, CreateDate from setting_project_status where status = 'A'");
            echo json_encode($data);
      }

?>