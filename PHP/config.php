<?php
define('TITLE', 'AnonPost');		
define('SERVERNAME', 'localhost');
define('SQLHOST', 'localhost');		//MySQL server address, usually localhost
define('SQLUSER', 'root');		//MySQL user (must be changed)
define('SQLPASS', 'root');		//MySQL user's password (must be changed)
define('SQLDB', 'anonpost');		//Database used by image board
define('ADMIN_PASS', 'root');	//Janitor password  (CHANGE THIS YO)
define('IMG_DIR', 'Image/');		//Image directory (needs to be 777)
define('THUMB_DIR','Thumbnail/');		//Thumbnail directory (needs to be 777)
define('HOME',  'index.php');			//Site home directory (up one level by default
define('MAX_W',  '250');			//Images exceeding this width will be thumbnailed
define('MAX_H',  '250');			//Images exceeding this height will be thumbnailed
define('THUM_S', '0.2');			//Desired Thumbnail size (h, w) in percent 
define('SBP', '5');			//Seconds between posts (floodcheck)
define('MIS', '5000000');               //Max file Size
?>
