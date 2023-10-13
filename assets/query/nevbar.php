<?php
    include_once("../includes/function-db.php");
    
    $lang = $_POST["lang"]; 
    $_SESSION["lang"] = $lang;
    echo "Success";
    

?>