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
            <style>
                .column{

                }.thread {
                    vertical-align:top;
                    display:inline-block;
                    word-wrap:break-word;
                    overflow:hidden;
                    margin-top:5px;
                    margin-bottom:20px;
                    padding:5px 0 3px;
                    position:relative;
                }
                .thread a {
                    border:0
                }
                .thread img {
                    padding:5px 0 3px;
                    display:inline
                }
                .thread p{
                    padding:5px 0 3px;
                }
                .space{
                    margin-left:15px;
                    margin-right:15px;
                    padding:5px 0 3px;
                    position:relative;
                    display:inline-block;


                }
            </style>
        </head>
        <body style="background-color:#F1D816">
            <div class= "ui grid">
                <div class = "sixteen wide column"><?php printHTMLHeader() ?></div>
                <div class="sixteen wide column">
                    <h1 align="center">Welcome to <?php echo $name ?> Board</h1>
                </div>
                <div class="four wide column">
                </div>
                <div class="eight wide column">
                    <h2>Post a Thread</h2>
                    <p>Please read the rules before posting</p> 
                    <form action="NewThread.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="board" value="<?php echo $board ?>">
                        <input type="hidden" name="insertThread" value="true">
                        <table>
                            <tr>
                                <td>
                                    Name
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" name="name" value="Anonymous">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Trip Phrase
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" name="tripcode" value="">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Subject
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" name="subject" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Comment
                                </td>
                                <td>:</td>
                                <td>
                                    <textarea name="comment"></textarea>
                                </td>
                            </tr><tr>
                                <td>
                                    Image:
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="file" name='img' required="">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="submit" value="New Thread">
                                </td>
                            </tr>
                        </table>
                </div>
            </form>
            <div class="sixteen wide column"><h1 align="center">Threads</h1></div>
            <div class="ui container">
                <div class="sixteen wide column">
                    <div class="content">
                        <span class="space"></span>
                        <div class="threads">
                            <?php
                            $threads = getThread($board, true);
                            if ($threads) {
                                foreach ($threads as $thread) {
                                    $op = getThreadOP($thread['id_thread']);
                                    ?>
                                    <div class="thread" style="max-width:150px">
                                        <a href="Thread.php?id=<?php echo $thread['id_thread']; ?>&r=<?php echo hash('crc32', rand()); ?>" >
                                            <div class="ui small image" align="center">
                                                <img  src="<?php echo THUMB_DIR . $op['image']; ?>">
                                            </div>
                                        </a>
                                        <div>
                                            <p align="center" ><b>R</b> : <?php echo getThreadPostCount($thread['id_thread']); ?><br><?php echo '<b>' . $thread["subject"] . '</b> : ' . substr($op['comment'], 0, 90); ?></p>
                                        </div>

                                    </div>
                                    <span class="space"></span>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>  
        </div>

    </body>
    </html>
    <?php
} else {
    header("Location:index.php");
}
?>