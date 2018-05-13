<?php
	include_once "PHP/Functions.php";
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$thread = getThreadbyID($id);
		$posts = getPost($id);
 ?>
	<html>
		<head>
		<script type="text/javascript">
			function change(event){
				var image = document.getElementbyId('thumb');
				image.src="<?php IMG_DIR.$post['image']; ?>;"
			}
		</script>
			<?php getHead($thread['subject']);?>
			<link rel="stylesheet" type="text/css" href="CSS/custom/Thread.css">
		</head>
		<body style="background-color:#2E4874">
			<div class='úi grid'>
				<div class= "ui grid">
                <div class = "sixteen wide column"><?php printHTMLHeader() ?></div>
                <div class="four wide column">
                </div>
                <div class="eight wide column">
                <div class="ui segment">
					  <a class="ui ribbon label" href="Board.php?board=10001&r=c6d3776eeed6486e76a1b56463f5670d">Back to Threads</a>
					  <div class="eight wide column" id="mainview">
						<?php 
							foreach($posts as $post){
						?>
						<div class="ui grid">
							 <div class="ui basic segment">
							 	<div class="eight wide column">
							 		<h1 class="ui header"><?php echo $post['poster_name']?></h1>	
							 	</div>
							 </div>
						</div>
						<div class="ui stacked segment">
							<div class="ui threaded comments">
						  		<div class="comment">
						    		<div class="content">
						     			<i class="address card icon"></i>
						      			<a class="author">
						      			ID : <?php echo $post['id_poster']?>
						      			</a>
						      			</br>
						      			<i class="paper plane outline icon"></i>
						      			<a class="trip-code">
						      				Trip-code : <?php echo $post['trip_code']?>
						      			</a>
						     			</br>
						      			<i class="calendar icon"></i>
						      			<div class="metadata">
						        			<span class="date">
						        				<?php echo $post['time_posted']?>
						        			</span>
						      			</div><br>
						      			<?php if ($post['image']){?>
						       			<div class="ui small left floated rounded image">
						       			<a>
	                                	<img  src="<?php echo THUMB_DIR . $post['image']; ?>" alt="" onclick="change(event)" id="thumb">
	                                	</a>
	                            		</div>
	                           			<?php }?>
						      			<div class="text">
	                            		<h4><?php echo $post['comment']?></h4>
						      			</div>
						    		</div>
						  		</div>
							</div>
						</div>
						<?php
							}
						?>
					</div>
					<div class="four wide column">
					</div>
					<div class="four wide column">
	                </div>
	                <div class="eight wide column">
	                    <h2>Post Comment</h2>
	                    <p>Please read the rules before posting</p> 
	                    <?php printHTMLNewPOSTForm($id);?>
					</div>
					<div class="four wide column">
	                </div>
					</div>
					</div>
				
				
			</div>
		</body>
	</html>
 <?php
	}else{
		header('location:index.php');
	}
 ?>