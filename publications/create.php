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
                                <small style="color:#e26330">Publications / Create</small>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <form id="frm-data" method="post">   
                                <input type="hidden" id="flagAction" name="flagAction" className="form-control" value="add" />
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
                                <div class="col-sm-12 py-2" style="text-align:end;">
                                    <a href="/publications" type="button" class="btn btn-danger" >Cancel</a>
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
<script src="../js/publications.js"></script>
