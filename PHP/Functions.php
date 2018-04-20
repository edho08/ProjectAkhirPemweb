<?php
	include_once 'Database.php';
	function getHead( $title ){
	session_start();
?>
		<title><?php echo $title;?></title>
		<link rel="stylesheet" type="text/css" href="CSS/semantic/semantic.min.css">
		<script type= "text/javascript", src = "scripts/jquery-3.3.1.min.js"></script>
<?php }?>

<?php
	function printHTMLBoard(){
		$arrayofBoard = getBoards();
?>
		<form action="Thread.php" method="POST">
<?php
		foreach($arrayofBoard as $Board){
?>	
		<button name='board' type='submit' class="ui button" value="<?php echo $Board['id_board']; ?>"> <?php echo $Board['name']; ?> </button>
<?php
		}
		
	}
?>

<?php
	function printHTMLHeader(){
		?>
			<div class="head">
				<table>
				<tr>
					<td>
						[<img src="logo.jpg" href = "index.php"></img>]
					<td>
					<td>
						[<a href="index.php">HOME</a>]
					</td>
				</tr>
				
				</table>
			</div>
		<?php
	}
?>

<?php
	function getActiveThread($boardID){
		
	}
	function getBoardBanner($board){
		
	}
	function getSessionID(){
		return session_id();
	}
	function getPosterID($threadID){
		return hash('crc32',getSessionID().$threadID);
	}
?>