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
				<div class="four wide column">
                </div>
                <div class="eight wide column">
					<div class="ui message">
                    <h1 align="center">Welcome to <?php echo $name ?> Board</h1>
					</div>
				</div>
				<div class="four wide column">
                </div>
                <div class="four wide column">
                </div>
                <div class="eight wide column">
                    <div class="ui form">
                      
                    </div><br>
                    <div class="sixteen wide column"></div>
                        <span class="space"></span>
                        <?php
                        $threads = getThread($board, true);
                        if ($threads) {
                        foreach ($threads as $thread) {
                        $op = getThreadOP($thread['id_thread']);
                        ?>
                        <div class="ui message">
                            <a href="Thread.php?id=<?php echo $thread['id_thread']; ?>&r=<?php echo hash('crc32', rand()); ?> &boardid= <?php echo $board ?>" >
                            <div class="thread">
							<?php if($_SESSION['isAdmin']){?>
							<form action="archiveThread.php" method="POST">
								<input type="hidden" name="threadID" value="<?php echo $thread['id_thread'] ?>">
								<input type="hidden" name="board" value="<?php echo $board ?>">
								<div class="one fields">
									<div class="field">                
										<button class="ui tiny button" >Archive</button>
									</div>
								</div>
							</form>
						<?php }?>
                                <img class="ui small left floated image" src="<?php echo THUMB_DIR . $op['image']; ?>" height="125" width="125">
							<h1><?php echo '<b>' . $thread["subject"] . '</b>'?></h1>
							<h3><?php echo '<b>' . $op["poster_name"] . '</b>'?></h3>
                            </div>
							</a>
							<div class="comment" style="  overflow-wrap: break-word;">
							<p><?php echo substr($op['comment'], 0, 300); ?></p>
							<b   overflow: auto;>R</b> : <?php echo getThreadPostCount($thread['id_thread']); ?>
							</div>
                        </div>
                    <?php
                    }
                    }
                    ?>
                </div>
				<div class="four wide column">
                </div>
				<div class="four wide column">
                </div>
                <div class="eight wide column">
				<div class="ui message">
                        <div class="header"><h2>Post a Thread</h2></div>
                        <ul class="list">
							<p>Please read the <a href="faq.php">rules</a> before posting</p> 
							<a href="index.php">go back</a>
                        </ul>
                      </div>
				    <?php printHTMLNewThreadForm($board); ?>
				</div>
			</div>
        </body>
    </html>
    <?php
} else {
    header("Location:index.php");
}
?>