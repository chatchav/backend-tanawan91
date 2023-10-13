<?php
    include_once("../includes/function-db.php");
    
    $username = $_POST["username"]; 
    $password = base64_encode($_POST["password"]); 

    $res = sql_query("select * from users where status = 'A' and username='".$username."' and password='".$password."'");
    $n_rows = mysqli_num_rows($res);
    if($n_rows > 0){
        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $_SESSION["fullName"] =  $row["firstname"]." ".$row["lastname"];
        $_SESSION["uId"] = $row["uId"];
        echo "Success";
    }else{
        echo "Invalid username or password";
    }
    

?>