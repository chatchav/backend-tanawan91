<!DOCTYPE html>
<html lang="en">

    <?php 
        session_start();
        include_once "../assets/includes/header.html";
        include_once "../assets/includes/connect-db.php";

        global $con;
        $resType = mysqli_query($con, "SELECT typeId, typeName FROM `setting_project_type` WHERE status = 'A' ORDER BY `typeName` ASC");
        $resStatus = mysqli_query($con, "SELECT statusId, statusName FROM `setting_project_status` WHERE status = 'A' ORDER BY `statusName` ASC");
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
                                <h1 class="mt-4 mb-0">PROJECTS</h1>
                                <small style="color:#e26330">Projects</small>
                            </div>
                            <div class="col-sm-2 div-btn">
                                <button type="button" id="add-service" class="mt-4 btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Project</button>
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
                                                <th>Type</th>
                                                <th>Create Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                global $con;
                                                $lang ="";
                                                if(@$_SESSION["lang"] != "EN"){
                                                    $lang = "_th";
                                                }
                                                $result = mysqli_query($con, "select projectId, image, title, t.typeName, p.CreateDate from projects".$lang." p inner join setting_project_type t on t.typeId = p.typeId where p.status = 'A' order by p.createDate desc");
                                                
                                                while ($row = mysqli_fetch_row($result)) {
                                            ?>
                                                <tr>
                                                    <td>
                                                        <img src="/assets/img/user-upload/<?php echo $row[1];?>" width="150px" alt="">    
                                                    </td>
                                                    <td><?php echo $row[2];?></td>
                                                    <td><?php echo $row[3];?></td>
                                                    <td><?php echo $row[4];?></td>
                                                    <td>
                                                        <a href="/projects/edit.php?id=<?php echo $row[0];?>" type="button" class="btn btn-warning btn-edit-data m-1" data-id="<?php echo $row[0];?>" ><i class="fa-regular fa-pen-to-square"></i></a>
                                                        <button type="button" class="btn btn-danger btn-del-data m-1" data-id="<?php echo $row[0];?>"><i class="fa-regular fa-trash-can"></i></button>
                                                    </td>
                                                </tr>
                                            
                                            <?php
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
<script src="/js/projects.js"></script>
