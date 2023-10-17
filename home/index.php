<!DOCTYPE html>
<html lang="en">

    <?php 
        include_once "../assets/includes/header.html";
        include_once "../assets/includes/connect-db.php";

        global $con;
        $resAbout = mysqli_query($con, "select aboutId, title from about where status = 'A' order by createDate desc");
    ?>
    
    <body class="sb-nav-fixed">
        
        <?php include_once "../assets/includes/nevbar.php";?>
    
        <div id="layoutSidenav">
            
            <?php include_once "../assets/includes/slidebar.html";?>
            
            
        </div>
        <!-- Modal -->
       
        <?php include_once "../assets/includes/footer.html";?>
    </body>
</html>
<script src="js/home-about.js"></script>
