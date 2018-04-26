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
		<form action="Board.php" method="POST">
<?php
		if($arrayofBoard){
			foreach($arrayofBoard as $Board){
?>	
		<button name='board' type='submit' class="ui red small button" value="<?php echo $Board['id_board']; ?>"> <?php echo $Board['name']; ?> </button>
<?php
			}
		}
	}
?>

<?php
	function printHTMLHeader(){
		?>
		<div class="ui tiny menu">
			<a class="item" href="index.php">
				Home
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