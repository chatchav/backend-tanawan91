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
                                <h1 class="mt-4 mb-0">SLIDER</h1>
                                <small style="color:#e26330">Home Page / Slider</small>
                            </div>
                            <div class="col-sm-2 div-btn">
                                <button type="button" id="add-service" class="mt-4 btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Images</button>
                            </div>
                        </div>
                        
                        
                        <div class="card-body">
                            <table class="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Images</th>
                                        <th>Create Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        global $con;
                                        $result = mysqli_query($con, "select sliderId, image, CreateDate from homeslider where status = 'A' order by createDate desc");
                                        
                                        while ($row = mysqli_fetch_row($result)) {
                                    ?>
                                        <tr>
                                            <td>
                                                <img src="/assets/img/user-upload/<?php echo $row[1];?>" width="150px" alt="">    
                                            </td>
                                            <td><?php echo $row[2];?></td>
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
            <div class="modal-dialog" style="padding-top:10%">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Images</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="frm-data" method="post">   
                        <input type="hidden" id="flagAction" name="flagAction" className="form-control" />
                        <input type="hidden" id="id" name="id" className="form-control" /> 
                        <div class="modal-body">
                            <div class="row py-2" id="img-cover" style="display:none">
                                <div class="col-10">
                                    <img width="150px" alt="" id="img-temp">
                                    <input type="hidden" name="img-old" id="img-old">
                                </div>
                            </div>
                            <input type="file" name="image" id="image">
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
<script src="js/home-slider.js"></script>
