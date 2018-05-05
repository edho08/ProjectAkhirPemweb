<html>
	<head>
	<?php include "PHP\Functions.php";
		getHead("AnonPost");
	?>
	</head>
	<body style="background-color:#2E4874">
		<?php printHTMLHeader();?>
		<div id="pesan">
		<div class="ui message">
  			<div class="header">
		    AnonPost.com is a simple image-based bulletin board where anyone can post comments and share images. There are boards dedicated to a variety of topics, from Stupid animation and culture to videogames, music, and photography. Users do not need to register an account before participating in the community. Feel free to click on a board below that interests you and jump right in!
			Be sure to familiarize yourself with the Rules before posting, and read the FAQ if you wish to learn more about how to use the site
		  	</div>
		  	<p>We just updated our privacy policy here to better service our customers. We recommend reviewing the changes.</p>
		</div>
			<div class="ui big message">
		  		<div class="header">
		    		<h1>Boards</h1>
		  		</div>
		  		<ul class="list">
		    		<ul>
		    			<?php printHTMLBoard();?>
		    			<?php getBoards();?>
		    		</ul>

		  		</ul>
			</div>
		</div>
	</body>
</html>