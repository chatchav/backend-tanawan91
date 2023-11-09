<!DOCTYPE html>
<html lang="en">

    <?php 
     @session_start(); 
        include_once "../assets/includes/header.html";
        include_once "../assets/includes/connect-db.php";

        global $con;
        $lang ="";
        if($_SESSION["lang"] != "EN"){
            $lang = "_th";
        }
        $result = mysqli_query($con,"SELECT * FROM `setting_website` WHERE page = 'service'");
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $img1 = !empty($row["img1"])?$row["img1"]:"";
        $img2 = !empty($row["img2"])?$row["img2"]:"";
        $title = !empty($row["title"])?$row["title"]:"";
        $title_th = !empty($row["title_th"])?$row["title_th"]:"";
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
                                <h1 class="mt-4 mb-0">SETTING</h1>
                                <small style="color:#e26330">Setting / Service</small>
                            </div>
                        </div>
                        <form id="frm-data" enctype="multipart/form-data" method="post">
                            <input type="hidden" id="flagAction" name="flagAction" class="form-control" value="update">
                            <input type="hidden" id="page" name="page" class="form-control" value="service">
                            <div class="card-body">
                                <!-- Tabs content -->
                                <?php if($img1 != ""){ ?>
                                    <div class="row py-2" id="img-cover">
                                        <div class="col-2"></div>
                                        <div class="col-10">
                                            <img width="150px" src="/assets/img/user-upload/<?php echo $img1;?>" alt="" id="img-temp">
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="row py-2">
                                    <div class="col-2">
                                        <label for="image" class="col-form-label">Image Design Build : </label>
                                    </div>
                                    <div class="col-10">
                                        <input type="file" name="image1" id="image1">
                                        <input type="hidden" name="img-old1" id="img-old1" value="<?php echo $img1;?>">
                                    </div>
                                </div>
                                <?php if($img2 != ""){ ?>
                                    <div class="row py-2" id="img-cover">
                                        <div class="col-2"></div>
                                        <div class="col-10">
                                            <img width="150px" src="/assets/img/user-upload/<?php echo $img2;?>" alt="" id="img-temp">
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="row py-2">
                                    <div class="col-2">
                                        <label for="image" class="col-form-label">Image Build : </label>
                                    </div>
                                    <div class="col-10">
                                        <input type="file" name="image2" id="image2">
                                        <input type="hidden" name="img-old2" id="img-old2" value="<?php echo $img2;?>">
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

<script src="../js/setting-service.js"></script>
