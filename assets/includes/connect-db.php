<?php

    include __DIR__.'../../../config.php';

    $con = mysqli_connect($db_host, $db_user, $db_password, $db_name);
    /* check connection */
    if (!$con) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

   
?>