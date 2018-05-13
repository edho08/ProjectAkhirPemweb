<?php
include "PHP/Functions.php";
if (isset($_POST["insertThread"]) && time() - $_SESSION['laspost']>SBP) {
    $name = $_POST["name"];
    $subject = $_POST["subject"];
    $tripcode = $_POST["tripcode"];
    $comment = $_POST["comment"];
    $tmp_img = $_FILES["img"]["tmp_name"];
    $img = $_FILES["img"]["name"];
    $board = $_POST["board"];
    if (!checkImage($tmp_img)) {
		unlink($tmp_img);
        header("location:index.php");
    }
    move_uploaded_file($tmp_img, $img);
    insertNewThread($board, session_id(), $subject, $comment, $name, $tripcode, $img);
	$_SESSION['laspost'] = time();
    header("location:Board.php?board=$board&r=".hash('crc32',time().session_id()));
} else {
	header("location:index.php");
}