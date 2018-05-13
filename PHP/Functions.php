<?php
include_once 'Database.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function getHead($title) {
    ?>
    <title><?php echo TITLE . ' - '. $title; ?></title>
    <link rel="stylesheet" type="text/css" href="CSS/custom/index.css">
    <link rel="stylesheet" type="text/css" href="CSS/dist/semantic.min.css">
    <script
    src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
    crossorigin="anonymous"></script>
    <script src="semantic/dist/semantic.min.js"></script>
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
            <a href="<?php echo "Board.php?board=$id&r=$r"; ?>"><?php echo $Board["name"]; ?>
            </a>
            <?php echo "<br>";?>
            <?php
        }

    }
}
?>

<?php

function printHTMLHeader() {
    ?>
    <div class="ui inverted menu">
          <div class="item"><a href="index.php">Anon Post</a></div>
          <a class="item" href="rule.php">Rules</a>
          <a class="item" href="faq.php">FAQ</a>
          <a class="item"><div class="ui category search">
          <div class="ui icon input">
            <input class="prompt" type="text" placeholder="Search Post">
            <i class="search icon" onclick=""></i>
          </div>
          <div class="results"></div>
        </div></a>
        <div class="right menu">
            <div class="item">
                <a class="item" href="">Login Admin</a>
            </div>
          </div>
        </div>
    <?php
}
?>

<?php

function printHTMLNewPostForm($thread) {
    ?>
    <form action="newPost.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="thread" value="<?php echo $thread ?>">
        <input type="hidden" name="insertPost" value="true">
        <div class="ui inverted segment">
            <div class="ui inverted form">
                <div class="one fields">
                    <div class="field">
                        <label>Name</label>
                        <input type="text" value="anonymous" name="name">
                    </div>
                </div>
                <div class="one fields">
                    <div class="field">
                        <label>Trip phrase</label>
                        <input type="text" name="tripcode">
                    </div>
                </div>
                    <div class="field">
                        <label>Comment</label>
                        <textarea name="comment"></textarea>
                    </div>
                <div class="one field">
                    <input type="file" name='img'>
                </div>
                <div class="one fields">
                    <div class="field">                
                            <button class="ui button">POST</button>
                    </div>
                </div>
            </div>                      
        </div>  
    </form> 
    <?php
}
?>
<?php

function printHTMLNewThreadForm($board) {
    ?>
    <form action="NewThread.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="board" value="<?php echo $board ?>">
        <input type="hidden" name="insertThread" value="true">
        <div class="ui inverted segment">
            <div class="ui inverted form">
                <div class="two fields">
                    <div class="field">
                        <label>Name</label>
                        <input type="text" value="anonymous" name="name">
                    </div>
                </div>
                <div class="two fields">
                    <div class="field">
                        <label>Trip phrase</label>
                        <input type="text" name="tripcode">
                    </div>
                </div>
                <div class="two fields">
                    <div class="field">
                        <label>subject</label>
                        <input type="text" required="subject" name="subject">
                    </div>
                </div>
                    <div class="ui form">
                        <div class="field">
                            <label>Comment</label>
                            <textarea name="comment"></textarea>
                        </div>
                    </div><br>
                <input type="file" name='img' required=""><br><br>
                <div class="one fields">
                    <div class="field">                                
                        <div class="field">                
                            <button class="ui button">POST</button>
                    </div>
                    </div>
                </div>
            </div>                      
        </div>  
    </form> 
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