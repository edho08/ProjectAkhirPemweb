<?php
	if(isset($_POST["board"])){
	echo $_POST["board"];
?>
<?php
	}else{
		header("Location:index.php");
	}
?>