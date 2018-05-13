<?php
include "PHP/Functions.php";
if (isset($_GET["board"])) {
    $board = $_GET["board"];
    $name = getBoardName($board);
    ?>
    <html>
        <head>
            <?php
            getHead($name);
            ?>
            <link rel="stylesheet" type="text/css" href="CSS/custom/Board.css">
        </head>
        <body style="background-color:#2E4874">
            <div class= "ui grid">
                <div class = "sixteen wide column"><?php printHTMLHeader() ?></div>
                <div class="sixteen wide column">
                    <h1 align="center">Welcome to <?php echo $name ?> Board</h1>
                </div>
                <div class="four wide column">
                </div>
                <div class="eight wide column">
                    <div class="ui form">
                      <div class="ui message">
                        <div class="header"><h2>Post a Thread</h2></div>
                        <ul class="list">
                          <p>Please read the rules before posting</p> 
                        </ul>
                      </div>
                    </div><br>
                    <?php printHTMLNewThreadForm($board); ?>
                    <div class="sixteen wide column"><h1 align="center">Threads</h1></div>
                        <span class="space"></span>
                        <?php
                        $threads = getThread($board, true);
                        if ($threads) {
                        foreach ($threads as $thread) {
                        $op = getThreadOP($thread['id_thread']);
                        ?>
                        <div class="ui message">
                            <a href="Thread.php?id=<?php echo $thread['id_thread']; ?>&r=<?php echo hash('crc32', rand()); ?>" >
                            <div class="thread">
                                <img class="ui small left floated image" src="<?php echo THUMB_DIR . $op['image']; ?>" height="125" width="125">
                            <p align="justify" ><b>R</b> : <?php echo getThreadPostCount($thread['id_thread']); ?><br><?php echo '<b>' . $thread["subject"] . '</b> : ' . substr($op['comment'], 0, 300); ?></p>
                            </div>
                        </div>
                    <?php
                    }
                    }
                    ?>
                </div>
        </body>
    </html>
    <?php
} else {
    header("Location:index.php");
}
?>