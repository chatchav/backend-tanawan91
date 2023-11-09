<!DOCTYPE html>
<html lang="en">

    <?php 
        include_once "../assets/includes/header.html";
        include_once "../assets/includes/connect-db.php";

        global $con;
        $resAbout = mysqli_query($con, "select aboutId, title from about where status = 'A' order by seq asc");
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
                                <h1 class="mt-4 mb-0">HOME ABOUT</h1>
                                <small style="color:#e26330">Home Page / About</small>
                            </div>
                            <div class="col-sm-2 div-btn">
                                <button type="button" id="add-service" class="mt-4 btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add About</button>
                            </div>
                        </div>
                        
                        
                        <div class="card-body">
                            <table class="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Images</th>
                                        <th>Title</th>
                                        <th>Create Date</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        global $con;
                                        $result = mysqli_query($con, "SELECT h.aboutId, a.image, a.title, h.createDate FROM `home_about` h INNER JOIN about a ON a.aboutId = h.aboutId WHERE h.status = 'A' order by h.seq asc");
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
                                            <td>
                                                <button type="button" <?php echo  $disup;?> class="btn btn-light btn-sort m-1" data-sort="up" data-id="<?php echo $row[0];?>"><i class="fa-solid fa-arrow-up"></i></button>
                                                <button type="button" <?php echo  $disdown;?> class="btn btn-light btn-sort m-1" data-sort="down" data-id="<?php echo $row[0];?>"><i class="fa-solid fa-arrow-down"></i></button>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-edit-data m-1" data-id="<?php echo $row[0];?>" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-regular fa-pen-to-square"></i></button>
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
                        <div class="row py-2">
                                <div class="col-12">
                                <select class="form-select js-example-basic-single" style="width: 100%;" id="aboutId" name="aboutId" aria-label="Default select example">
                                    <option value="">Choose about</option>
                                    <?php 
                                        while ($rowA = mysqli_fetch_row($resAbout)) {
                                    ?>
                                        <option value="<?php echo $rowA[0];?>"><?php echo $rowA[1];?></option>
                                    <?php 
                                        } 
                                    ?>
                                </select>
                                <small id="txtErr" style="color:red;display:none"></small>
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
<script src="/js/home-about.js"></script>
