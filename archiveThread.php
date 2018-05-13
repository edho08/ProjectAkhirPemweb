<?php
include_once "PHP/Functions.php";
if(isset($_POST["threadID"])&& $_SESSION['isAdmin']){
	archiveThread($_POST["threadID"]);
	$board =  $_POST['board'];
	header("Location:Board.php?board=$board");
}else{
	header("Location:index.php");
}
?>