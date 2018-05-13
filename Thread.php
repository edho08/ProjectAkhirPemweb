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
			function change(id){
				var image = document.getElementById(id);
				var thumb = document.getElementById("THM" +id);
				var img = document.getElementById("IMG" +id);
				if(thumb.style.display== "none"){
					thumb.style.display="";
					img.style.display = "none";
				} else {
					img.style.display = "";
					thumb.style.display = "none";
				}
			}
			function highlightPosterID(posterid){
					var posts = document.getElementsByClassName("Post");
					for(var i =0; i< posts.length; i++){
						var container = posts[i].getElementsByClassName("ui stacked segment")[0];
						container.style.backgroundColor = "";
						if(posts[i].id.indexOf(posterid)>-1){
							container.style.backgroundColor = "yellow";
						}
					}
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
					  <div class="eight wide column" id="mainview">
						<?php 
							foreach($posts as $post){
						?>
							<div class= "Post" id="post<?php echo $post['id_post'].$post['id_poster']?>" >
							<div class="ui stacked segment">
								<div class="ui threaded comments">
									<div class="comment">
										<div class="content">
											<h1 class="ui header"><?php echo $post['poster_name']?></h1>	
											<i class="address card icon"></i>
											<a class="author" onclick=highlightPosterID('<?php echo $post['id_poster']?>')>
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
											<div class="ui small left floated rounded image" id="img<?php echo $post['id_post']?>">
											<a>
											<img  src="<?php echo THUMB_DIR . $post['image']; ?>" alt="" onclick=change("img<?php echo $post['id_post']?>") id="THMimg<?php echo $post['id_post']?>")>
											</a>
											</div>
											<div class="ui large left floated rounded image" id="img<?php echo $post['id_post']?>">
											<a>
											<img style="display:none"  src="<?php echo IMG_DIR . $post['image']; ?>" alt="" onclick=change("img<?php echo $post['id_post']?>") id="IMGimg<?php echo $post['id_post']?>">
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
							</div>
						<?php
							}
						?>
						</div>

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