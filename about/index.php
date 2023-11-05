<!DOCTYPE html>
<html lang="en">

    <?php 
        session_start();
        include_once "../assets/includes/header.html";
        include_once "../assets/includes/connect-db.php";

        global $con;
        $lang ="";
        if($_SESSION["lang"] != "EN"){
            $lang = "_th";
        }
        $result = mysqli_query($con, "select aboutId, image, title, description, CreateDate from about".$lang." where status = 'A' order by seq asc");

    ?>
    
    <body class="sb-nav-fixed">
        
        <?php include_once "../assets/includes/nevbar.php";?>
    
        <div id="layoutSidenav">
            
            <?php include_once "../assets/includes/slidebar.html";?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <div class="row col-sm-12 mb-4">
                            <div class="col-sm-10">
                                <h1 class="mt-4 mb-0">ABOUT</h1>
                                <small style="color:#e26330">About</small>
                            </div>
                            <div class="col-sm-2 div-btn">
                                <button type="button" id="add-service" class="mt-4 btn btn-primary" >Add </button>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <!-- Tabs content -->
                            <div class="tab-content" id="ex1-content">
                                <div class="tab-pane fade show active" id="design">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Create Date</th>
                                                <th></th>
                                                <th style="width:200px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i = 0;
                                                $n_rows = mysqli_num_rows($result);
                                                while ($row = mysqli_fetch_row($result)) {
                                                    $disup = "";
                                                    $disdown = "";
                                                    if ($i == 0) {
                                                        $disup = "disabled";
                                                    }
                                                    if($i == ($n_rows-1)){
                                                        $disdown = "disabled";
                                                    }
                                            ?>
                                                <tr>
                                                    <td>
                                                        <img src="/assets/img/user-upload/<?php echo $row[1];?>" width="150px" alt="">    
                                                    </td>
                                                    <td><?php echo $row[2];?></td>
                                                    <td><?php echo $row[3];?></td>
                                                    <td><?php echo $row[4];?></td>
                                                    <td>
                                                        <button type="button" <?php echo  $disup;?> class="btn btn-light btn-sort m-1" data-sort="up" data-id="<?php echo $row[0];?>"><i class="fa-solid fa-arrow-up"></i></button>
                                                        <button type="button" <?php echo  $disdown;?> class="btn btn-light btn-sort m-1" data-sort="down" data-id="<?php echo $row[0];?>"><i class="fa-solid fa-arrow-down"></i></button>
                                                    </td>
                                                    <td width="200px">
                                                        <a href="/about/edit.php?id=<?php echo $row[0];?>" type="button" class="btn btn-warning btn-edit-data m-1" data-id="<?php echo $row[0];?>" ><i class="fa-regular fa-pen-to-square"></i></a>
                                                        <button type="button" class="btn btn-danger btn-del-data m-1" data-id="<?php echo $row[0];?>"><i class="fa-regular fa-trash-can"></i></button>
                                                    </td>
                                                </tr>
                                            <?php
                                                $i++;
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Tabs content -->
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <!-- Modal -->
        
        <?php include_once "../assets/includes/footer.html";?>
        
    </body>
</html>
<script src="/js/about.js"></script>
