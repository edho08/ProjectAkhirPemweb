<?php 
    echo "Success";
    $head = $_REQUEST["url"];
    header("location:".$_REQUEST["url"]);
?>