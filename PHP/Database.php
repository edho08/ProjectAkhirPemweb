<?php
	include "config.php";
	function getConnection($username, $password = null){
		$con = new mysqli(SERVERNAME, $username, $password, SQLDB);
		//mysql_select_db('database', $con);
		if(!$con){
			die("Connection to Database failed");
		} else return $con;
		
	}
	function addAdmin($adminName, $adminPass){
		$hashedAdminPass = substr(hash('md5',$adminPass),0,16);
		$con = getConnection(SQLUSER,SQLPASS);
		$statement = $con->prepare("INSERT INTO `admin`(`id_admin`, `hashed_pass`) VALUES (?,?)");
		$statement->bind_param("ss",$adminName,$hashedAdminPass);
		$statement->execute() or die($statement->error);
		return true;	
	}
	function isAdminExist($adminName, $adminPass){
		$hashedAdminPass = substr(hash('md5',$adminPass),0,16);
		$con = getConnection(SQLUSER,SQLPASS);
		$statement = $con->prepare("SELECT COUNT(*) FROM `admin` WHERE `id_admin` = ? AND `hashed_pass` = ?");
		$statement->bind_param("ss",$adminName, $hashedAdminPass);
		$statement->execute() or die($statement->error);
		$statement->bind_result($result);
		$statement->fetch();
		return $result;
	}
	
	function AdminChangePassword($adminName, $adminPass, $newAdminPass){
		$hashedAdminPass = substr(hash('md5',$adminPass),0,8);
		$con = getConnection(SQLUSER,SQLPASS);
		$statement = $con->prepare("UPDATE `admin` SET `hashed_pass`= ? WHERE `ID_Admin`= ? ");
		$statement->bind_param("ss",$hashedAdminPass, $adminName);
		$statement->execute();
		return true;
	}
	function getBoards(){
		$con = getConnection(SQLUSER,SQLPASS);
		$statement = $con->prepare("SELECT id_board, name, max_thread FROM board");
		$statement->execute();
		$statement->bind_result($id_board, $name, $max_thread);
		while($statement->fetch()){
			$board[] = [$id_board, $name, $max_thread]; 
		}
		return $board;
	}
	function isPosterIDExist($posterID, $threadID){
		$con = getConnection(SQLUSER,SQLPASS);
		$statement = $con->prepare("SELECT COUNT(`id_poster`) FROM `poster` WHERE `id_poster` = ? AND id_thread = ?");
		$statement->bind_param("si",$posterID, $threadID);
		$statement->execute();
		$statement->bind_result($result);
		$statement->fetch();
		return $result;
	}
	function insertNewPoster($threadID, $sessionID){
		$posterID = generatePosterID($threadID, $sessionID);
		$con = getConnection(SQLUSER,SQLPASS);
		$statement = $con->prepare("INSERT INTO Poster(id_poster, id_thread, session_id) VALUES (?,?,?)");
		$statement->bind_param("sis",$posterID, $threadID, $sessionID);
		$statement->execute();
		return true;
	}
	
	function insertNewPost($sessionID, $threadID,  $comment, $posterName = "Anon", $tripPhrase = null, $imagePath = null){
		if($imagePath){
			$newImageName = generateImageName($imagePath);
			$thumbnail = make_thumb($imagePath, THUMB_DIR.$newImageName.".jpg");
			$imagePath = rename($imagePath, IMG_DIR.$newImageName.".jpg");
		} else $thumbnail = null;
		if($tripPhrase){
			$tripCode = generateTripCode($tripPhrase);
		} else $tripCode = null;
		$reply_no = getThreadPostCount($threadID);
		// Generate Poster
		$posterID = generatePosterID($sessionID,$threadID);
		if(!isPosterIDExist($posterID,$threadID)){
			insertNewPoster($threadID, $sessionID);
		}
		$con = getConnection(SQLUSER,SQLPASS);
		$statement = $con->prepare("INSERT INTO Post(id_thread, id_poster, reply_no, poster_name, trip_code, comment, image) VALUES (?,?,?,?,?,?,?)");
		$statement->bind_param("isissss", $threadID, $posterID, $reply_no, $posterName, $tripCode, $comment, $newImageName);
		$statement->execute();
		return true;
	}
	function getPost($threadID){
		
	}
	function getPostsByTripCode($tripPhrase){
		$tripCode = generateTripCode($tripPhrase);
		$con = getConnection(SQLUSER,SQLPASS);
		$statement = $con->prepare("SELECT `id_post`, `id_thread`, `id_poster`, `reply_no`, `poster_name`, `trip_code`, `comment`, `image`, `num_of_report` FROM `post` WHERE trip_code = ?");
		$statement->bind_param('s',$tripCode);
		$statement->execute();
		$statement->bind_result($id_post, $id_thread, $id_poster, $reply_no, $poster_name, $trip_code, $comment, $image, $num_of_report);
		while($statement->fetch()){
			$post[] = ['id_post'=>$id_post, "id_thread" => $id_thread, "id_poster"=>$id_poster, "reply_no"=>$reply_no, "poster_name"=>$poster_name, "trip_code"=>$trip_code, "comment"=>$comment, "image"=>$image, "num_of_report"=>$num_of_report]; 
		}
		return $post;
	}
	
	function getThreadPostCount($threadID){
		$con = getConnection(SQLUSER,SQLPASS);
		$statement = $con->prepare("SELECT COUNT(id_post) FROM Post WHERE id_thread = ?");
		$statement->bind_param("i",$threadID);
		$statement->execute();
		$statement->bind_result($result);
		$statement->fetch();
		return $result;
	}
	function getThreadsIDNext(){
		$con = getConnection(SQLUSER,SQLPASS);
		$statement = $con->prepare("SELECT MAX(id_thread) FROM Thread");
		$statement->execute();
		$statement->bind_result($result);
		$statement->fetch();
		return ++$result;
	}
	
	function insertNewThread($boardID, $sessionID, $subject, $comment, $posterName = "Anon", $tripPhrase = null, $imagePath = null){
		$threadID = getThreadsIDNext();
		$datetime = date("Y-m-d H:i:s");
		$con = getConnection(SQLUSER,SQLPASS);
		$statement = $con->prepare("INSERT INTO Thread (id_thread, id_board, creation_date, subject) VALUES (?,?,?,?)");
		$statement->bind_param("ssss",$threadID, $boardID, $datetime , $subject);
		$statement->execute() or die("Cannot Insert Thread");
		insertNewPost($sessionID, $threadID, $posterName, $comment, $tripPhrase, $imagePath);
	}
	function getActiveThreadCount(){
		
	}
	function ArchieveThread(){
		
	}
	
	
	function generateTripCode($tripPhrase){
		return substr(hash('md5', $tripPhrase),0,16);
	}
	function generatePosterID($sessionID, $threadID){
		return hash('crc32', $sessionID.$threadID);
	}
	function generateImageName($imageName){
		$newImageName = rand();
		do{
		$newImageName = hash('crc32',$newImageName.$imageName). hash('crc32', $imageName.$newImageName);
		return $newImageName;
		}while(checkImageExistance($newImageName));
	}
	function checkImageExistance($imageName){
		$con = getConnection(SQLUSER,SQLPASS);
		$statement = $con->prepare("SELECT COUNT(id_post) FROM Post WHERE image = ?");
		$statement->bind_param("s",$imageName);
		$statement->execute();
		$statement->bind_result($result);
		$statement->fetch();
		return $result;
	}
	
	function make_thumb($src, $dest) {
		$source_image = imagecreatefromjpeg($src);
		$width = imagesx($source_image);
		$height = imagesy($source_image);
		$virtual_image = imagecreatetruecolor(MAX_W, MAX_H);
		imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, MAX_W, MAX_H, $width, $height);
		imagejpeg($virtual_image, $dest);
	}
?>