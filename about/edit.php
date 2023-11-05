<!DOCTYPE html>
<html lang="en">

    <?php 
        session_start();
        include_once "../assets/includes/header.html";
        include_once "../assets/includes/connect-db.php";

        global $con;
        $lang ="";
        if($_SESSION["lang"] != "EN"){
            $lang = "_th";
        }
        $id = $_GET["id"];

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
                                <h1 class="mt-4 mb-0">ABOUT</h1>
                                <small style="color:#e26330">About / Edit</small>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <form id="frm-data" enctype="multipart/form-data" method="post">
                                <input type="hidden" id="flagAction" name="flagAction" class="form-control" value="add">
                                <input type="hidden" id="id" name="id" class="form-control" value="<?php echo $id;?>">
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
                                <div class="col-sm-12 py-2" style="text-align:end;">
                                    <a href="/about" type="button" class="btn btn-danger" >Cancel</a>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </main>
                
            </div>
        </div>
        <?php include_once "../assets/includes/footer.html";?>
        
    </body>
</html>
<script src="/js/about.js"></script>
