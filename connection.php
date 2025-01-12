<?php 

     //Connection to database
     
    $con = new mysqli('localhost', 'root', '', 'anime_watch');

    if(!$con) {
    die(mysqli_error($con));
    }

?>