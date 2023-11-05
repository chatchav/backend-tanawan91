<!DOCTYPE html>
<html lang="en">

    <?php 
        @session_start(); 
        include_once "../assets/includes/header.html";
        include_once "../assets/includes/connect-db.php";
        $lang ="";
        if($_SESSION["lang"] != "EN"){
            $lang = "_th";
        }
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
                                <h1 class="mt-4 mb-0">SERVICES</h1>
                                <small style="color:#e26330">Services / Create</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="frm-data" method="post">   
                                <input type="hidden" id="flagAction" name="flagAction" className="form-control" value="add" />
                                <input type="hidden" id="id" name="id" className="form-control" /> 
                                <div class="row">
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
                                    <div class="row py-2">
                                        <div class="col-2">
                                            <label for="desc" class="col-form-label">Detail : </label>
                                        </div>
                                        <div class="col-10">
                                        <textarea class="form-control" placeholder="" id="desc" name="desc" style="height: 150px"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 py-2" style="text-align:end;">
                                    <a href="/services" type="button" class="btn btn-danger" >Cancel</a>
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
<script src="../js/services.js"></script>
