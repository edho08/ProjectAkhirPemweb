<?php
include_once 'Database.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function getHead($title) {
    ?>
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" type="text/css" href="CSS/semantic/semantic.min.css">
    <script src="scripts/jquery-3.3.1.min.js"</script>
    <script src="CSS/semantic/semantic.min.js"></script>
<?php } ?>

<?php

function printHTMLBoard() {
    $arrayofBoard = getBoards();
    $r = hash('md5', session_id() . rand());
    ?>     
    <?php
    if ($arrayofBoard) {
        foreach ($arrayofBoard as $Board) {
            $id=$Board['id_board'];
            $name=$Board['name'];
            ?>	
            <a href="<?php echo "Board.php?board=$id&r=$r"; ?>"><?php echo $Board["name"]; ?></a>
            <?php
        }
    }
}
?>

<?php

function printHTMLHeader() {
    ?>
    <div class="ui tiny menu">
        <a class="item" href="index.php">
            AnonPost
        </a>
        <a class="active item" href="rule.php">
            Rules
        </a>
        <a class="active item" href="faq.php">
            FAQ
        </a>
    </div>

    <?php
}
?>

<?php

function getActiveThread($boardID) {
    
}

function getBoardBanner($board) {
    
}

function getSessionID() {
    return session_id();
}

function getPosterID($threadID) {
    return hash('crc32', getSessionID() . $threadID);
}
?>