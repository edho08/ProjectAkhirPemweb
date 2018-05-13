<?php

include "config.php";

function getConnection($username, $password = null) {
    $con = new mysqli(SERVERNAME, $username, $password, SQLDB) or die("Cannot connect to database");
    $con->autocommit(TRUE);
    return $con;
}

function closeConnection($con) {
    $con->commit();
    mysqli_close($con);
}

function addAdmin($adminName, $adminPass) {
    $hashedAdminPass = substr(hash('md5', $adminPass), 0, 16);
    $con = getConnection(SQLUSER, SQLPASS);
    $statement = $con->prepare("INSERT INTO `admin`(`id_admin`, `hashed_pass`) VALUES (?,?)");
    $statement->bind_param("ss", $adminName, $hashedAdminPass);
    $statement->execute() or die($statement->error);
    closeConnection($con);
    return true;
}

function isAdminExist($adminName, $adminPass) {
    $hashedAdminPass = substr(hash('md5', $adminPass), 0, 16);
    $con = getConnection(SQLUSER, SQLPASS);
    $statement = $con->prepare("SELECT COUNT(*) FROM `admin` WHERE `id_admin` = ? AND `hashed_pass` = ?");
    $statement->bind_param("ss", $adminName, $hashedAdminPass);
    $statement->execute() or die($statement->error);
    $statement->bind_result($result);
    $statement->fetch();
    closeConnection($con);
    return $result;
}

function AdminChangePassword($adminName, $adminPass, $newAdminPass) {
    $hashedAdminPass = substr(hash('md5', $adminPass), 0, 8);
    $con = getConnection(SQLUSER, SQLPASS);
    $statement = $con->prepare("UPDATE `admin` SET `hashed_pass`= ? WHERE `ID_Admin`= ? ");
    $statement->bind_param("ss", $hashedAdminPass, $adminName);
    $statement->execute();
    closeConnection($con);
    return true;
}

function getBoards() {
    $con = getConnection(SQLUSER, SQLPASS);
    $statement = $con->prepare("SELECT id_board, name, max_thread FROM board");
    $statement->execute();
    $statement->bind_result($id_board, $name, $max_thread);
    $board = null;
    while ($statement->fetch()) {
        $board[] = ["id_board" => $id_board, "name" => $name, "max_thread" => $max_thread];
    }
    closeConnection($con);
    return $board;
}

function getBoardName($idBoard) {
    $con = getConnection(SQLUSER, SQLPASS);
    $statement = $con->prepare("SELECT name FROM board WHERE id_board = ?");
    $statement->bind_param('s', $idBoard);
    $statement->execute();
    $statement->bind_result($name);
    $board = null;
    $statement->fetch();
    closeConnection($con);
    return $name;
}

function isPosterIDExist($posterID, $threadID) {
    $con = getConnection(SQLUSER, SQLPASS);
    $statement = $con->prepare("SELECT COUNT(`id_poster`) FROM `poster` WHERE `id_poster` = ? AND id_thread = ?");
    $statement->bind_param("si", $posterID, $threadID);
    $statement->execute();
    $statement->bind_result($result);
    $statement->fetch();
    closeConnection($con);
    return $result;
}

function insertNewPoster($threadID, $sessionID) {
    $posterID = generatePosterID($threadID, $sessionID);
    $con = getConnection(SQLUSER, SQLPASS);
    $statement = $con->prepare("INSERT INTO Poster(id_poster, id_thread, session_id) VALUES (?,?,?)");
    $statement->bind_param("sis", $posterID, $threadID, $sessionID);
    $statement->execute();
    closeConnection($con);
    return true;
}

function insertNewPost($sessionID, $threadID, $comment, $posterName = "Anon", $tripPhrase = null, $imagePath = null) {
	echo getcwd();
    echo $imagePath;
    if ($imagePath) {
        if(checkImage($imagePath)){
            $newImageName = generateImageName($imagePath);
            $thumbnail = make_thumb($imagePath, THUMB_DIR . $newImageName);
            $newImageName = $newImageName . generateImageExtension($imagePath);
            $imagePath = rename($imagePath, IMG_DIR . $newImageName);
        } 
    }else
        $thumbnail = null;
    if ($tripPhrase) {
        $tripCode = generateTripCode($tripPhrase);
    } else
        $tripCode = null;
    $reply_no = getThreadPostCount($threadID);
    // Generate Poster
    $posterID = generatePosterID($sessionID, $threadID);
    if (!isPosterIDExist($posterID, $threadID)) {
        insertNewPoster($threadID, $sessionID);
    }
    $con = getConnection(SQLUSER, SQLPASS);
    $time = date("Y-m-d H:i:s");
    $statement = $con->prepare("INSERT INTO Post(id_thread, id_poster, reply_no, poster_name, trip_code, comment, image, time_posted) VALUES (?,?,?,?,?,?,?,?)");
    $statement->bind_param("isisssss", $threadID, $posterID, $reply_no, $posterName, $tripCode, $comment, $newImageName, $time);
    $statement->execute() or die("Unable to insert new Post");
    //update BUMP
    $statement = $con->prepare("UPDATE thread SET last_bump = ? WHERE id_thread = ?");
    $statement->bind_param("si", $time, $threadID);
    $statement->execute() or die("Unable to UPDATE BUMP");
    closeConnection($con);
    return true;
}

function getPost($threadID) {
    $con = getConnection(SQLUSER, SQLPASS);
    $statement = $con->prepare("SELECT `id_post`, `id_thread`, `id_poster`, `reply_no`, `poster_name`, `trip_code`, `comment`, `image`, `num_of_report`, `time_posted`  FROM `post` WHERE id_thread = ? ORDER BY reply_no");
    $statement->bind_param('s', $threadID);
    $statement->execute();
    $statement->bind_result($id_post, $id_thread, $id_poster, $reply_no, $poster_name, $trip_code, $comment, $image, $num_of_report, $time_posted);
    while ($statement->fetch()) {
        $post[] = ['id_post' => $id_post, "id_thread" => $id_thread, "id_poster" => $id_poster, "reply_no" => $reply_no, "poster_name" => $poster_name, "trip_code" => $trip_code, "comment" => $comment, "image" => $image, "num_of_report" => $num_of_report, 'time_posted'=>$time_posted];
    }
    closeConnection($con);
    return $post;
}

function getPostsByTripPhrase($tripPhrase) {
    $tripCode = generateTripCode($tripPhrase);
	getPostsByTripCode($tripCode);
    
}
function getPostsByTripCode($tripCode) {
	$con = getConnection(SQLUSER, SQLPASS);
    $statement = $con->prepare("SELECT `id_post`, `id_thread`, `id_poster`, `reply_no`, `poster_name`, `trip_code`, `comment`, `image`, `num_of_report`, `time_posted` FROM `post` WHERE trip_code = ?");
    $statement->bind_param('s', $tripCode);
    $statement->execute();
    $statement->bind_result($id_post, $id_thread, $id_poster, $reply_no, $poster_name, $trip_code, $comment, $image, $num_of_report, $time_posted);
    while ($statement->fetch()) {
        $post[] = ['id_post' => $id_post, "id_thread" => $id_thread, "id_poster" => $id_poster, "reply_no" => $reply_no, "poster_name" => $poster_name, "trip_code" => $trip_code, "comment" => $comment, "image" => $image, "num_of_report" => $num_of_report, 'time_posted'=>$time_posted];
    }
    closeConnection($con);
    return $post;
}
function getThreadPostCount($threadID) {
    $con = getConnection(SQLUSER, SQLPASS);
    $statement = $con->prepare("SELECT COUNT(id_post) FROM Post WHERE id_thread = ?");
    $statement->bind_param("i", $threadID);
    $statement->execute();
    $statement->bind_result($result);
    $statement->fetch();
    closeConnection($con);
    return $result;
}

function getThreadsIDNext() {
    $con = getConnection(SQLUSER, SQLPASS);
    $statement = $con->prepare("SELECT MAX(id_thread) FROM Thread");
    $statement->execute();
    $statement->bind_result($result);
    $statement->fetch();
    closeConnection($con);
    return ++$result;
}

function insertNewThread($boardID, $sessionID, $subject, $comment, $posterName = "Anon", $tripPhrase = null, $imagePath = null) {
    $threadID = getThreadsIDNext();
    $datetime = date("Y-m-d H:i:s");
    $con = getConnection(SQLUSER, SQLPASS);
    $statement = $con->prepare("INSERT INTO Thread (id_thread, id_board, creation_date, subject, last_bump) VALUES (?,?,?,?,?)");
    $statement->bind_param("sssss", $threadID, $boardID, $datetime, $subject, $datetime);
    $statement->execute() or die("Cannot Insert Thread");
    insertNewPost($sessionID, $threadID, $comment, $posterName, $tripPhrase, $imagePath);
    closeConnection($con);
}

function getActiveThreadCount($board) {
    $con = getConnection(SQLUSER, SQLPASS);
    $statement = $con->prepare("SELECT count(*) FROM `thread` WHERE id_board = ?");
    $statement->bind_param('s', $board);
    $statement->execute();
    $statement->bind_result($count);
    $statement->fetch();
    closeConnection($con);
    return $count;
}

function getThread($board, $isActive = false) {
    $con = getConnection(SQLUSER, SQLPASS);
    $statement = $con->prepare("SELECT `id_thread`, `id_board`, `max_post`, `creation_date`, `subject`, `sticky`, `num_of_report` FROM `thread` WHERE id_board = ? AND is_archieved = ? ORDER BY last_bump DESC");
    $statement->bind_param('sb', $board, $isActive);
    $statement->execute();
    $statement->bind_result($id_thread, $id_board, $max_post, $creation_date, $subject, $sticky, $num_of_report);
    $threads = null;
    while ($statement->fetch()) {
        $threads[] = ["id_thread" => $id_thread, "id_board" => $id_board, "max_post" => $max_post, "creation_date" => $creation_date, "subject" => $subject, "sticky" => $sticky, "num_of_report" => $num_of_report];
    }
    closeConnection($con);
    return $threads;
}

function getThreadOP($threadID) {
    $con = getConnection(SQLUSER, SQLPASS);
    $statement = $con->prepare("SELECT `id_post`, `id_thread`, `id_poster`, `reply_no`, `poster_name`, `trip_code`, `comment`, `image`, `num_of_report` FROM `post` WHERE id_thread = ? AND reply_no = 0");
    $statement->bind_param('s', $threadID);
    $statement->execute();
    $statement->bind_result($id_post, $id_thread, $id_poster, $reply_no, $poster_name, $trip_code, $comment, $image, $num_of_report);
    $statement->fetch();
    $post = ['id_post' => $id_post, "id_thread" => $id_thread, "id_poster" => $id_poster, "reply_no" => $reply_no, "poster_name" => $poster_name, "trip_code" => $trip_code, "comment" => $comment, "image" => $image, "num_of_report" => $num_of_report];
    closeConnection($con);
    return $post;
}
function getThreadbyID($threadID){
	$con = getConnection(SQLUSER, SQLPASS);
    $statement = $con->prepare("SELECT `id_thread`, `id_board`, `max_post`, `creation_date`, `subject`, `sticky`, `num_of_report` FROM `thread` WHERE id_thread = ?");
    $statement->bind_param('i', $threadID);
    $statement->execute();
    $statement->bind_result($id_thread, $id_board, $max_post, $creation_date, $subject, $sticky, $num_of_report);
    $thread = null;
    $statement->fetch();
    $thread = ["id_thread" => $id_thread, "id_board" => $id_board, "max_post" => $max_post, "creation_date" => $creation_date, "subject" => $subject, "sticky" => $sticky, "num_of_report" => $num_of_report];
    closeConnection($con);
    return $thread;
}
function archiveThread($threadID){
	$con = getConnection(SQLUSER, SQLPASS);
    $statement = $con->prepare("UPDATE thread SET is_archieved = 1 WHERE id_thread=?");
    $statement->bind_param('i', $threadID);
    $statement->execute();
    closeConnection($con);
}

function generateTripCode($tripPhrase) {
    return substr(hash('md5', $tripPhrase), 0, 16);
}

function generatePosterID($sessionID, $threadID) {
    return hash('crc32', $sessionID . $threadID);
}

function generateImageName($imageName) {
    $newImageName = rand();
    do {
        $newImageName = hash('crc32', $newImageName . $imageName) . hash('crc32', $imageName . $newImageName);
    } while (checkImageExistance($newImageName));
    return $newImageName;
}

function generateImageExtension($imageName) {
    $image = getimagesize($imageName);
    switch ($image[2]) {
        case IMG_GIF:
            $newImageName = '.gif';
            break;
        case IMG_JPG:
            $newImageName = '.jpg';

            break;
        case IMG_PNG:
            $newImageName = '.png';

            break;
        case IMG_WBMP:
            $newImageName = '.wbmp';
            break;
        default:
            die("Cannot process image");
    }
    return $newImageName;
}

function checkImageExistance($imageName) {
    $con = getConnection(SQLUSER, SQLPASS);
    $statement = $con->prepare("SELECT COUNT(id_post) FROM Post WHERE image = ?");
    $statement->bind_param("s", $imageName);
    $statement->execute();
    $statement->bind_result($result);
    $statement->fetch();
    return $result;
}

function make_thumb($src, $dest) {
    if (checkImage($src)) {
        $image = getimagesize($src);
        echo $image[2];
        echo IMG_PNG;
        switch ($image[2]) {
            case IMG_GIF:
                $source_image = imagecreatefromgif($src);
                break;
            case IMG_JPG:
                $source_image = imagecreatefromjpeg($src);
                break;
            case IMG_PNG:
                $source_image = imagecreatefrompng($src);
                break;
            case IMG_WBMP:
                $source_image = imagecreatefromwbmp($src);
                break;
            default:
                die("Cannot process image");
        }
        $width = imagesx($source_image);
        $height = imagesy($source_image);
        $virtual_image = imagecreatetruecolor(MAX_W, MAX_H);
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, MAX_W, MAX_H, $width, $height);
        imagejpeg($virtual_image, $dest . generateImageExtension($src));
    }
}

function checkImage($src) {
    if (getimagesize($src)) {
        return true;
    } else {
        unlink($src);
        return false;
    }
}

?>