<?php
    include_once("../includes/function-db.php");
    
    $flag = $_POST["flagAction"];
    $title = (isset($_POST["title"]) ? $_POST["title"] : "");
    $keyword = (isset($_POST["keyword"]) ? $_POST["keyword"] : "");
    $shortdesc = htmlspecialchars((isset($_POST["metadesc"]) ? $_POST["metadesc"] : ""), ENT_QUOTES);
    $desc = htmlspecialchars((isset($_POST["desc"]) ? $_POST["desc"] : ""), ENT_QUOTES);
    $type = (isset($_POST["type"]) ? $_POST["type"] : "");
    $status = (isset($_POST["status"]) ? $_POST["status"] : "");
    $year = (isset($_POST["year"]) ? $_POST["year"] : "");
    $location = (isset($_POST["location"]) ? $_POST["location"] : "");
    $area = (isset($_POST["area"]) ? $_POST["area"] : "");
    $client = (isset($_POST["client"]) ? $_POST["client"] : "");
    $architect = (isset($_POST["architect"]) ? $_POST["architect"] : "");
    $contractor = (isset($_POST["contractor"]) ? $_POST["contractor"] : "");
    $imgOld = (isset($_POST["img-old"]) ? $_POST["img-old"] : "");
    $countAlbum = !empty($_FILES["albums"]["name"])?count($_FILES["albums"]["name"]):0;
    $albums = !empty($_FILES["albums"]["name"])?$_FILES["albums"]:"";
    //$title_th = (isset($_POST["title_th"]) ? $_POST["title_th"] : "");

    $urlFriendly = "";
    if($title != ""){
        $urlFriendly = str_replace(" ","-",strtolower($title)); 
    }

    $lang ="";
    if($_SESSION["lang"] != "EN"){
        $lang = "_th";
    }
    // echo "<pre>";
    // print_r($_POST);
    // print_r($_FILES);
    // print_r($albums);
    // echo "</pre>";
    $imgName = $imgOld;
    if(!empty($_FILES["image"]["name"])){
        $imgName = uploagImg($_FILES["image"],$imgOld);
    }

    

    switch ($flag) {
        case "add":
            $lastId = query_insert("insert into projects".$lang."(
                image, 
                title, 
                urlFriendly, 
                keyword, 
                description, 
                shortDescription,
                typeId,
                year,	
                location,
                projectStatusId,
                area,	
                client,	
                architect,	
                contractor,
                status,
                createDate
            )values(
                '".$imgName."', 
                '".$title."', 
                '".$urlFriendly."',
                '".$keyword."',
                '".$desc."',
                '".$shortdesc."',
                '".$type."',
                '".$year."',
                '".$location."',
                '".$status."',
                '".$area."',
                '".$client."',
                '".$architect."',
                '".$contractor."',
                'A',
                NOW()
            )
            ");

            if($lang == ""){
                sql_query(
                "insert into projects_th(
                    image, 
                    title, 
                    urlFriendly, 
                    keyword, 
                    description, 
                    shortDescription,
                    typeId,
                    year,	
                    location,
                    projectStatusId,
                    area,	
                    client,	
                    architect,	
                    contractor,
                    status,
                    createDate
                )values(
                    '".$imgName."', 
                    '".$title."', 
                    '".$urlFriendly."',
                    '".$keyword."',
                    '".$desc."',
                    '".$shortdesc."',
                    '".$type."',
                    '".$year."',
                    '".$location."',
                    '".$status."',
                    '".$area."',
                    '".$client."',
                    '".$architect."',
                    '".$contractor."',
                    'A',
                    NOW()
                )
                ");
            }
            for($i = 0; $i<$countAlbum; $i++){
                $imgOld = (isset($_POST["albumOld"][0]) ? $_POST["albumOld"][0] : "");
                $imgName = $imgOld;
                if(!empty($albums["name"][$i])){
                    $imgName = uploagImg($albums,$imgOld,$i);
                }
                sql_query("
                    insert into project_albums(
                        image, 
                        projectId
                    )values(
                        '".$imgName."', 
                        '".$lastId."'
                    )
                ");
            }
            echo "Success";
            
            break;
        case "update":
            $id = $_POST["id"];
            sql_query("
                update projects".$lang."
                set 
                    image = '".$imgName."', 
                    title = '".$title."', 
                    keyword = '".$keyword."', 
                    description = '".$desc."', 
                    shortDescription = '".$shortdesc."',
                    typeId = '".$type."',
                    year = '".$year."',	
                    location = '".$location."',
                    projectStatusId = '".$status."',
                    area = '".$area."',	
                    client = '".$client."',	
                    architect = '".$architect."',	
                    contractor = '".$contractor."'
                where projectId = '".$id."'
            ");
            sql_query("delete from project_albums where projectId = '".$id."'");
            for($i = 0; $i<$countAlbum; $i++){
                $imgOld = (isset($_POST["albumOld"][$i]) ? $_POST["albumOld"][$i] : "");
                $imgName = $imgOld;
                if(!empty($albums["name"][$i])){
                    $imgName = uploagImg($albums,$imgOld,$i);
                }
                sql_query("
                    insert into project_albums(
                        image, 
                        projectId
                    )values(
                        '".$imgName."', 
                        '".$id."'
                    )
                ");
            }
            echo "Success";
            
            break;
        case "edit":
            $id = $_POST["id"];
            $data = ["info"=>null,"albums"=>null];
            $dataInfo = getRowsData("
            select 
                image, 
                title,
                keyword, 
                description, 
                shortDescription,
                typeId,
                year,	
                location,
                projectStatusId,
                area,	
                client,	
                architect,
                contractor  
            from projects".$lang." where status = 'A' and projectId = '".$id."'");
            $dataInfo[0][3] = htmlspecialchars_decode($dataInfo[0][3]);
            $dataInfo[0][4] = htmlspecialchars_decode($dataInfo[0][4]);

            $dataAlbums = getRowsData("select image from project_albums where projectId = '".$id."'");
            
            $data["info"] = $dataInfo[0];
            $data["albums"] = $dataAlbums;
            echo json_encode($data);
          break;
        case "del":
            $id = $_POST["id"];
            $res = sql_query("
                update projects
                set status = 'D'
                where projectId = '".$id."'
            ");
            $res = sql_query("
                update projects_th
                set status = 'D'
                where projectId = '".$id."'
            ");
            echo "Success";
          break;
          case "sortup":
            $id = $_POST["id"];
            $res = sql_query("
                select seq, DownID, DownSorterIndex, UpID, UpSorterIndex 
                from( 
                    SELECT projectId , seq, 
                        lead(projectId ) over(order by seq desc) DownID, 
                        lag(projectId ) over(order by seq desc) UpID, 
                        lead(seq) over(order by seq desc) DownSorterIndex, 
                        lag(seq) over(order by seq desc) UpSorterIndex 
                    FROM projects 
                    where Status = 'A' 
                ) a 
                where projectId = '".$id."' 
            ");
            while ($row = mysqli_fetch_row($res)) {
                $upSeq = $row[4];
                $upId = $row[3];
                $seq = $row[0];
                $res1 = sql_query("update projects set seq = '".$upSeq."' where projectId = '".$id."'");
                $res2 = sql_query("update projects_th set seq = '".$seq."' where projectId = '".$upId."'");

                $res1 = sql_query("update projects_th set seq = '".$upSeq."' where projectId = '".$id."'");
                $res2 = sql_query("update projects_th set seq = '".$seq."' where projectId = '".$upId."'");
            }
            echo "Success";
        break;
        case "sortdown":
            $id = $_POST["id"];
            $res = sql_query("
                select seq, DownID, DownSorterIndex, UpID, UpSorterIndex 
                from( 
                    SELECT projectId , seq, 
                        lead(projectId ) over(order by seq desc) DownID, 
                        lag(projectId ) over(order by seq desc) UpID, 
                        lead(seq) over(order by seq desc) DownSorterIndex, 
                        lag(seq) over(order by seq desc) UpSorterIndex 
                    FROM projects 
                    where Status = 'A' 
                ) a 
                where projectId = '".$id."' 
            ");
            while ($row = mysqli_fetch_row($res)) {
                $downSeq = $row[2];
                $downId = $row[1];
                $seq = $row[0];
                $res1 = sql_query("update projects set seq = '".$downSeq."' where projectId = '".$id."'");
                $res2 = sql_query("update projects set seq = '".$seq."' where projectId = '".$downId."'");

                $res1 = sql_query("update projects_th set seq = '".$downSeq."' where projectId = '".$id."'");
                $res2 = sql_query("update projects_th set seq = '".$seq."' where projectId = '".$downId."'");
            }
            echo "Success";
          break;
        default:
            $data = getRowsData("select statusId, statusName, CreateDate from setting_project_status where status = 'A'");
            echo json_encode($data);
    }

?>