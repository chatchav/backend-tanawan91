<?php
    $con = mysqli_connect('localhost', 'root', '', 'tanawan91');
    /* check connection */
    if (!$con) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
?>