<?php
	include_once "PHP/Functions.php";
	if(isset($_GET['tripcode'])){
		$tripcode = $_GET['tripcode'];
		$posts = getPostsByTripCode($tripcode);
		
		foreach($posts as $post){
			$threads[$post['id_thread']] = getThreadbyID($post['id_thread']);
		}
		foreach($threads as $id=>$thread){
			$thread["post"][] = getThreadOP($id);
		}
		foreach($posts as $post){
			$threads[$post['id_thread']]["post"][] = $post;
		}
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
			<?php getHead("Search : $tripcode");?>
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
						foreach($threads as $thread){
							?>
						<div class="Thread">	
						<span class="space"></span>
                        <div class="ui message">
                            <a href="Thread.php?id=<?php echo $thread['id_thread']; ?>&r=<?php echo hash('crc32', rand()); ?>" >
							<h1><?php echo '<b>' . $thread["subject"] . '</b>'?>
							</1>  
 
							<?php
							foreach($thread["post"] as $post){
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
											<div class="text">
											<h4><?php echo $post['comment']?></h4>
											</div>
										</div>
									</div>
								</div>
							</div>
							</div>

							<?php
														
							}?>
						</div>
						</div>

							<?php
						}
									
						?>
							
						
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