<?php
	function getHeader( $title ){
	session_start();
?>
	<head>
		<title><?php echo $title;?></title>
		<link rel="stylesheet" type="text/css" href="CSS/semantic/semantic.min.css">
		<script type= "text/javascript", src = "scripts/jquery-3.3.1.min.js"></script>
	</head>
<?php }?>

<?php
	function printHTMLBoard(){
		$arrayofBoard = getBoardList();
?>
		<form action="/Thread.php" method="POST">
<?php
		foreach($arrayofBoard as $Board){
?>	
		<button name='board' type='submit' value="<?php echo $Board['ID']; ?>"> <?php echo $Board['name']; ?> </button>
<?php
		}
		
	}
?>

<?php
	function getBoardList(){
		$file = fopen('board.txt','r') or die('couldnt access board');
		$array = [];
		while(!feof($file)){
			$data = fgets($file);
			if($data){
				$string = explode(';',$data);
				$array[] = ['ID' => $string[0], 'name' => $string[1]];
			}
		}
		return $array;
	}
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