<!DOCTYPE html>
<html lang="en">

    <?php 
        include_once "../assets/includes/header.html";
        include_once "../assets/includes/connect-db.php";

    ?>
    
    <body class="sb-nav-fixed">
        
        <?php include_once "../assets/includes/nevbar.html";?>
    
        <div id="layoutSidenav">
            
            <?php include_once "../assets/includes/slidebar.html";?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <div class="row col-sm-12 mb-4">
                            <div class="col-sm-10">
                                <h1 class="mt-4 mb-0">SERVICES</h1>
                                <small style="color:#e26330">Services</small>
                            </div>
                            <div class="col-sm-2 div-btn">
                                <button type="button" id="add-service" class="mt-4 btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Services</button>
                            </div>
                        </div>
                        
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#design">Design Build</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#build">Build</a>
                            </li>
                        </ul>

                        <br/>
                        <div class="card-body">
                            <!-- Tabs content -->
                            <div class="tab-content" id="ex1-content">
                                <div class="tab-pane fade show active" id="design">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Detail</th>
                                                <th>Create Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                global $con;
                                                $result = mysqli_query($con, "select serviceId, title, description, createDate  from services where status = 'A' and type = 'design'");
                                                
                                                while ($row = mysqli_fetch_row($result)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $row[1];?></td>
                                                    <td><?php echo $row[2];?></td>
                                                    <td><?php echo $row[3];?></td>
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
                                <div class="tab-pane fade show active" id="build">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Detail</th>
                                                <th>Create Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                global $con;
                                                $result = mysqli_query($con, "select serviceId, title, description, createDate  from services where status = 'A' and type = 'build'");
                                                
                                                while ($row = mysqli_fetch_row($result)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $row[1];?></td>
                                                    <td><?php echo $row[2];?></td>
                                                    <td><?php echo $row[3];?></td>
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
            <div class="modal-dialog" style="padding-top:10%">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="frm-data" method="post">   
                        <input type="hidden" id="flagAction" name="flagAction" className="form-control" />
                        <input type="hidden" id="id" name="id" className="form-control" /> 
                        <div class="modal-body">
                            <div class="row py-2 align-items-center">
                                <div class="col-2">
                                    <label for="title" class="col-form-label">Title : </label>
                                </div>
                                <div class="col-10">
                                    <input type="text" id="title" name="title" class="form-control" placeholder="Title">
                                </div>
                            </div>
                            <div class="row py-2 align-items-center">
                                <div class="col-2">
                                    <label for="type" class="col-form-label">Type : </label>
                                </div>
                                <div class="col-10">
                                    <select class="form-select" id="type" name="type" aria-label="Default select example">
                                        <option value="design" selected>Design Build</option>
                                        <option value="build">Build</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row py-2 align-items-center">
                                <div class="col-12">
                                    <label for="desc" class="col-form-label">Detail : </label>
                                </div>
                                <div class="col-12">
                                <textarea class="form-control" placeholder="" id="desc" name="desc" style="height: 150px"></textarea>
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
<script src="js/services.js"></script>