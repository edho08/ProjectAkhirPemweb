<?php
	include_once "PHP/Functions.php";
	if(isset($_POST['login'])){
		if(isAdminExist($_POST['name'], $_POST['pass'])){
			$_SESSION['adminID'] = $_POST['name'];
			$_SESSION['isAdmin'] = true;
		}
					header("location:index.php");

	}
	else if($_SESSION['adminID'] == -1){
		
	
 ?>
 <html>
        <head>
            <?php
            getHead("Auth");
            ?>
            <link rel="stylesheet" type="text/css" href="CSS/custom/Board.css">
        </head>
		<body style="background-color:#2E4874">
		<div class = "sixteen wide column"><?php printHTMLHeader() ?></div>
		<div class="ui container">
		<form action="auth.php" method="POST" align="center">
        <input type="hidden" name="login" value="true">
        <div class="ui inverted segment">
            <div class="ui inverted form">
                <div class="one fields">
                    <div class="field">
                        <label>Admin Name</label>
                        <input type="text" value="" name="name">
                    </div>
                </div>
                <div class="one fields">
                    <div class="field">
                        <label>Admin Pass</label>
                        <input type="password" name="pass">
                    </div>
                </div>
				<div class="one fields">
                    <div class="field">                
                            <button class="ui button">AUTH</button>
                    </div>
                </div>
            </div>                      
        </div>  
    </form>
		</div>
		</body>
<html>
 <?php 
	}else{
		$_SESSION['adminID'] = -1;
		$_SESSION['isAdmin'] = false;
			header("location:index.php");

	}

 ?>