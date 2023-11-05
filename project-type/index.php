<!DOCTYPE html>
<html lang="en">

    <?php 
        include_once "../assets/includes/header.html";
        include_once "../assets/includes/connect-db.php";
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
                                <h1 class="mt-4 mb-0">PROJECT TYPE</h1>
                                <small style="color:#e26330">Setting / Project Type</small>
                            </div>
                            <div class="col-sm-2 div-btn">
                                <button type="button" id="add-service" class="mt-4 btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Type</button>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <!-- Tabs content -->
                            <div class="tab-content" id="ex1-content">
                                <div class="tab-pane fade show active" id="design">
                                    <table id="data-tbl">
                                        <thead>
                                            <tr>
                                                <th>Type Name</th>
                                                <th>Create Date</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                global $con;
                                                $result = mysqli_query($con, "select typeId, typeName, CreateDate from setting_project_type where status = 'A' order by seq asc");
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
                                                    <td><?php echo $row[1];?></td>
                                                    <td><?php echo $row[2];?></td>
                                                    <td>
                                                        <button type="button" <?php echo  $disup;?> class="btn btn-light btn-sort m-1" data-sort="up" data-id="<?php echo $row[0];?>"><i class="fa-solid fa-arrow-up"></i></button>
                                                        <button type="button" <?php echo  $disdown;?> class="btn btn-light btn-sort m-1" data-sort="down" data-id="<?php echo $row[0];?>"><i class="fa-solid fa-arrow-down"></i></button>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning btn-edit-data" data-id="<?php echo $row[0];?>" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-regular fa-pen-to-square"></i></button>
                                                        <button type="button" class="btn btn-danger btn-del-data" data-id="<?php echo $row[0];?>"><i class="fa-regular fa-trash-can"></i></button>
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
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="padding-top:5%;max-width:none;width:800px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="frm-data" method="post">
                        <input type="hidden" id="flagAction" name="flagAction" class="form-control">
                        <input type="hidden" id="id" name="id" class="form-control">
                        <div class="modal-body">
                            <div class="row py-2">
                                <div class="col-3">
                                    <label for="title" class="col-form-label">Type Name : </label>
                                </div>
                                <div class="col-9">
                                    <input type="text" id="title" name="title" class="form-control" placeholder="Type Name">
                                    <small id="txtErrtitle" style="color:red;display:none"></small>
                                </div>
                            </div>
                            <div class="row py-2">
                                <div class="col-3">
                                    <label for="title" class="col-form-label">Type Name TH : </label>
                                </div>
                                <div class="col-9">
                                    <input type="text" id="title_th" name="title_th" class="form-control" placeholder="Type Name TH">
                                    <small id="txtErrtitle_th" style="color:red;display:none"></small>
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
<script src="../js/project-type.js"></script>
