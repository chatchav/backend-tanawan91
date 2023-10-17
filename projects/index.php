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
                                                        <button type="button" class="btn btn-warning btn-edit-data m-1" data-id="<?php echo $row[0];?>" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-regular fa-pen-to-square"></i></button>
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
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="padding-top:5%;max-width:none;width:1000px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="frm-data" method="post">
                        <input type="hidden" id="flagAction" name="flagAction" className="form-control" />
                        <input type="hidden" id="id" name="id" className="form-control" /> 
                        <div class="modal-body">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="#info">Information</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#albums">Albums</a>
                                </li>
                            </ul>
                            <div id="info">
                                <div class="row py-2" id="img-cover" style="display:none">
                                    <div class="col-2"></div>
                                    <div class="col-10">
                                        <img width="150px" alt="" id="img-temp">
                                        <input type="hidden" name="img-old" id="img-old">
                                    </div>
                                </div>
                                <div class="row py-2">
                                    <div class="col-2">
                                        <label for="image" class="col-form-label">Image : </label>
                                    </div>
                                    <div class="col-10">
                                        <input type="file" name="image" id="image">
                                    </div>
                                </div>
                                <div class="row py-2">
                                    <div class="col-2">
                                        <label for="title" class="col-form-label">Title : </label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" id="title" name="title" class="form-control" aria-describedby="passwordHelpInline">
                                    </div>
                                </div>
                                <div class="row py-2">
                                    <div class="col-2">
                                        <label for="keyword" class="col-form-label">Keyword : </label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" id="keyword" name="keyword" class="form-control" aria-describedby="passwordHelpInline">
                                    </div>
                                </div>
                                <div class="row py-2">
                                    <div class="col-2">
                                        <label for="shortdesc" class="col-form-label">Meta Description : </label>
                                    </div>
                                    <div class="col-10">
                                    <textarea class="form-control" placeholder="" rows="3" id="metadesc" name="metadesc"></textarea>
                                    </div>
                                </div>
                                <div class="row py-2 align-items-center">
                                    <div class="col-2">
                                        <label for="type" class="col-form-label">Type : </label>
                                    </div>
                                    <div class="col-4">
                                        <select class="form-select" id="type" name="type" aria-label="Default select example">
                                        <?php 
                                            while ($row = mysqli_fetch_row($resType)) {
                                        ?>
                                            <option value="<?php echo $row[0];?>"><?php echo $row[1];?></option>
                                        <?php 
                                            } 
                                        ?>
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <label for="type" class="col-form-label">Year : </label>
                                    </div>
                                    <div class="col-4">
                                        <input type="text" id="year" name="year" class="form-control" aria-describedby="passwordHelpInline">
                                    </div>
                                </div>
                                <div class="row py-2 align-items-center">
                                    <div class="col-2">
                                        <label for="type" class="col-form-label">Location : </label>
                                    </div>
                                    <div class="col-4">
                                        <input type="text" id="location" name="location" class="form-control" aria-describedby="passwordHelpInline">
                                    </div>
                                    <div class="col-2">
                                        <label for="type" class="col-form-label">Status : </label>
                                    </div>
                                    <div class="col-4">
                                        <select class="form-select" id="status" name="status" aria-label="Default select example">
                                        <?php 
                                            while ($rowS = mysqli_fetch_row($resStatus)) {
                                        ?>
                                            <option value="<?php echo $rowS[0];?>"><?php echo $rowS[1];?></option>
                                        <?php 
                                            } 
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row py-2 align-items-center">
                                    <div class="col-2">
                                        <label for="type" class="col-form-label">Area : </label>
                                    </div>
                                    <div class="col-4">
                                        <input type="text" id="area" name="area" class="form-control" aria-describedby="passwordHelpInline">
                                    </div>
                                    <div class="col-2">
                                        <label for="type" class="col-form-label">Client : </label>
                                    </div>
                                    <div class="col-4">
                                        <input type="text" id="client" name="client" class="form-control" aria-describedby="passwordHelpInline">
                                    </div>
                                </div>
                                <div class="row py-2 align-items-center">
                                    <div class="col-2">
                                        <label for="type" class="col-form-label">Architect : </label>
                                    </div>
                                    <div class="col-4">
                                        <input type="text" id="architect" name="architect" class="form-control" aria-describedby="passwordHelpInline">
                                    </div>
                                    <div class="col-2">
                                        <label for="type" class="col-form-label">Contractor : </label>
                                    </div>
                                    <div class="col-4">
                                        <input type="text" id="contractor" name="contractor" class="form-control" aria-describedby="passwordHelpInline">
                                    </div>
                                </div>
                                <div class="row py-2">
                                    <div class="col-2">
                                        <label for="desc" class="col-form-label">Description : </label>
                                    </div>
                                    <div class="col-10">
                                    <textarea class="form-control" placeholder="" id="desc" name="desc"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div id="albums" style="display:none;">
                                <div class="col-sm-12">
                                    <button type="button" id="add-image" class="mt-4 btn btn-primary">Add Image</button>
                                </div>
                                <div class="col-sm-12" id="form-albums" style="display: flex;flex-wrap: wrap;">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php include_once "../assets/includes/footer.html";?>
        
    </body>
</html>
<script src="js/projects.js"></script>
