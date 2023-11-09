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
        $result = mysqli_query($con,"SELECT * FROM `setting_website` WHERE page = 'about'");
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

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
                                <small style="color:#e26330">Setting / About</small>
                            </div>
                        </div>
                        <form id="frm-data" enctype="multipart/form-data" method="post">
                            <input type="hidden" id="flagAction" name="flagAction" class="form-control" value="update">
                            <input type="hidden" id="page" name="page" class="form-control" value="about">
                            <div class="card-body">
                                <!-- Tabs content -->
                                <div class="row py-2">
                                    <div class="col-2">
                                        <label for="title" class="col-form-label">Title : </label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" id="title" name="title" placeholder="Title" class="form-control" value="<?php echo $title;?>">
                                        <small id="txtErrtitle" style="color:red;display:none"></small>
                                    </div>
                                </div>
                                <div class="row py-2">
                                    <div class="col-2">
                                        <label for="title" class="col-form-label">Title TH : </label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" id="title_th" name="title_th" placeholder="Title TH" class="form-control" value="<?php echo $title_th;?>">
                                        <small id="txtErrtitle_th" style="color:red;display:none"></small>
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

<script src="../js/setting-about.js"></script>
