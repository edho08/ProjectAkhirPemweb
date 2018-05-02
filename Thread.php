<?php
	include_once "PHP/Functions.php";
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$thread = getThreadbyID($id);
		$posts = getPost($id);
 ?>
	<html>
		<head>
			<?php getHead($thread['subject']);?>
			<style>
				div.thread {
					 margin:0;
					 clear:both
					}
				div.opContainer {
					display:inline
				}
				div.replyContainer div.post div.file div.fileInfo {
					margin-left:20px
				}
			</style>
		</head>
		<body>
			<div class='úi grid'>
				<div class= "ui grid">
                <div class = "sixteen wide column"><?php printHTMLHeader() ?></div>
                <div class="sixteen wide column">
                </div>
                <div class="four wide column">
                </div>
                <div class="eight wide column">
                    <h2>Post a Thread</h2>
                    <p>Please read the rules before posting</p> 
                    <form action="newPost.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="thread" value="<?php echo $thread['id_thread'] ?>">
                        <input type="hidden" name="insertPost" value="true">
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
                                    <input type="file" name='img'>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="submit" value="New Thread">
                                </td>
                            </tr>
                        </table>
					</form>
				</div>
				<div class='sixteen wide column'>
					<?php 
						foreach($posts as $post){
					?>
					<div class='postContainer' style="background-color:red; width=50%">
						<span class='name'>
						<p color ='green'><?php echo $post['poster_name']?></p> 
						</span>
						<span class='id'>
						<p>(ID : <?php echo $post['id_poster']?>)</p>
						</span>
						</span class='datettime'>
						<p><?php echo $post['time_posted']?></p>
						</span>
						</span class='postno'>
						<p>No. <?php echo $post['id_post']?></p>
						</span>
						</span class='img'>
                            <div class="ui small image" align="center">
                                <img  src="<?php echo THUMB_DIR . $post['image']; ?>">
                            </div>
						</span>
						</span class='comment'>
						<p><?php echo $post['comment']?></p>
						</span>
					</div>
					<?php
						}
					?>
				</div>
			</div>
		</body>
	</html>
 <?php
	}else{
		header('location:index.php');
	}
 ?>