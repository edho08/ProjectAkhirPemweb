<?php
	session_start();
	include_once "PHP/Database.php";
	//make_thumb('logo.jpg','logo.jpg')
	//echo date("Y-m-d H:i:s");
	//addAdmin('edho08','edho0808');
	function print_ar($arr){
		foreach($arr as $value){
			if(is_array($value)){
				print_ar($value);
			}else{
				echo $value.' ';
			}
		}
		echo '<br>';
	}
	$arr = getBoards();
	print_ar($arr);
	echo $arr[0][0];
//	insertNewThread($arr[0][0], session_id(),'Its Da Jews', "I think this degeneracy must stop." , 'Anon' ,'Juancok');
//	insertNewPost(session_id(), 2, "I agree Anon, really makes you think doesnt it?", 'Anon', "TripCodeRule","Image/you.jpg");
	print_ar(getPostsByTripCode("TripCodeRule"));
	session_destroy();
?>