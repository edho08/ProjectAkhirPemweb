<?php
include "PHP/Functions.php";
if (isset($_POST["insertPost"])) {
    $name = $_POST["name"];
    $tripcode = $_POST["tripcode"];
    $comment = $_POST["comment"];
    $tmp_img = $_FILES["img"]["tmp_name"];
    $img = $_FILES["img"]["name"];
    $threadID = $_POST["thread"];
    echo $_POST["thread"];
    move_uploaded_file($tmp_img, $img);
    insertNewPost(session_id(), $threadID, $comment, $name, $tripcode, $img);
    header("location:Thread.php?id=$threadID&r=".hash('crc32',time().session_id()));
} else {
	header("location:index.php");
}
?>