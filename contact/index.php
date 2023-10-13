<!DOCTYPE html>
<html lang="en">

    <?php 
        include_once "../assets/includes/header.html";
        include_once "../assets/includes/connect-db.php";

        global $con;
        $result = mysqli_query($con,"select contactId, image, mapURL, description from contact");
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $display = !empty($row["image"])?"flex":"none";
        $img = !empty($row["image"])?$row["image"]:"";
        $mapURL = !empty($row["mapURL"])?$row["mapURL"]:"";
        $desc = !empty($row["description"])?$row["description"]:"";
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
                                <h1 class="mt-4 mb-0">CONTACT</h1>
                                <small style="color:#e26330">Contact</small>
                            </div>
                        </div>
                        <form id="frm-data" enctype="multipart/form-data" method="post">
                            <input type="hidden" id="flagAction" name="flagAction" class="form-control" value="update">
                            <input type="hidden" id="id" name="id" class="form-control">
                            <div class="card-body">
                                <!-- Tabs content -->
                                <div class="tab-content" id="ex1-content">
                                    <div class="row py-2" id="img-cover" style="display:<?php echo $display;?>">
                                        <div class="col-2"></div>
                                        <div class="col-10">
                                            <img width="150px" src="/assets/img/user-upload/<?php echo $img;?>" alt="" id="img-temp">
                                            <input type="hidden" name="img-old" id="img-old" value="<?php echo $img;?>">
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-2">
                                            <label for="image" class="col-form-label">Image Map : </label>
                                        </div>
                                        <div class="col-10">
                                            <input type="file" name="image" id="image">
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-2">
                                            <label for="mapURL" class="col-form-label">Map URL : </label>
                                        </div>
                                        <div class="col-10">
                                            <input type="text" class="form-control" name="mapURL" id="mapURL" value="<?php echo $mapURL;?>">
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-2">
                                            <label for="desc" class="col-form-label">Description : </label>
                                        </div>
                                        <div class="col-10">
                                        <textarea class="form-control" placeholder="" id="desc" name="desc"><?php echo $desc;?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- Tabs content -->
                                <div class="col-sm-12 py-2" style="text-align:end;">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </main>
                
            </div>
        </div>

        <?php include_once "../assets/includes/footer.html";?>
        
    </body>
</html>
<script src="js/contact.js"></script>
