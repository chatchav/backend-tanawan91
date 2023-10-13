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
                                <h1 class="mt-4 mb-0">ABOUT</h1>
                                <small style="color:#e26330">About</small>
                            </div>
                            <div class="col-sm-2 div-btn">
                                <button type="button" id="add-service" class="mt-4 btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add </button>
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
                                                <th style="width:200px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                global $con;
                                                $result = mysqli_query($con, "select aboutId, image, title, description, CreateDate from about where status = 'A'");
                                                
                                                while ($row = mysqli_fetch_row($result)) {
                                            ?>
                                                <tr>
                                                    <td>
                                                        <img src="/assets/img/user-upload/<?php echo $row[1];?>" width="150px" alt="">    
                                                    </td>
                                                    <td><?php echo $row[2];?></td>
                                                    <td><?php echo $row[3];?></td>
                                                    <td><?php echo $row[4];?></td>
                                                    <td width="200px">
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
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="padding-top:5%;max-width:none;width:1000px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="frm-data" enctype="multipart/form-data" method="post">
                        <input type="hidden" id="flagAction" name="flagAction" class="form-control">
                        <input type="hidden" id="id" name="id" class="form-control">
                        <div class="modal-body">
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
                                    <input type="text" id="title" name="title" class="form-control" placeholder="Title">
                                    <small id="txtErrtitle" style="color:red;display:none"></small>
                                </div>
                            </div>
                            <div class="row py-2">
                                <div class="col-2">
                                    <label for="keyword" class="col-form-label">Keyword : </label>
                                </div>
                                <div class="col-10">
                                    <input type="text" id="keyword" name="keyword" class="form-control" placeholder="Keyword">
                                    <small id="txtErrkeyword" style="color:red;display:none"></small>
                                </div>
                            </div>
                            <div class="row py-2">
                                <div class="col-2">
                                    <label for="desc" class="col-form-label">Description : </label>
                                </div>
                                <div class="col-10">
                                    <textarea class="form-control" placeholder="" rows="3" id="desc" name="desc"></textarea>
                                    <small id="txtErrdesc" style="color:red;display:none"></small>
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
<script src="js/about.js"></script>
