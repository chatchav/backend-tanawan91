<!DOCTYPE html>
<html lang="en">

    <?php
        session_start(); 
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
                                <h1 class="mt-4 mb-0">PUBLICATIONS</h1>
                                <small style="color:#e26330">Publications</small>
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
                                                <th>Create Date</th>
                                                <th></th>
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
                                                $result = mysqli_query($con, "select publicId, image, title, CreateDate from publications".$lang." where status = 'A' order by seq desc");
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
                                                        <a href="/publications/edit.php?id=<?php echo $row[0];?>" type="button" class="btn btn-warning btn-edit-data m-1" data-id="<?php echo $row[0];?>" ><i class="fa-regular fa-pen-to-square"></i></a>
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
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="padding-top:5%;max-width:none;width:1000px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Publications</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="frm-data" method="post">   
                        <input type="hidden" id="flagAction" name="flagAction" className="form-control" />
                        <input type="hidden" id="id" name="id" className="form-control" /> 
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
                                    <label for="shortdesc" class="col-form-label">Short Description : </label>
                                </div>
                                <div class="col-10">
                                <textarea class="form-control" placeholder="" rows="3" id="shortdesc" name="shortdesc"></textarea>
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
<script src="../js/publications.js"></script>
