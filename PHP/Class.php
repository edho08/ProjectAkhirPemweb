<?php
	class Post{
		$ID_Post;
		$ID_Thread;
		$Comment;
		$Poster_Name;
		$ID_Flag;
		$Picture_Path;
		
		//This function is used to create Object from this class using query
		public function __contruct($row){
			if(is_array($row)){
				$this->$ID_Post = $row['ID_Post'];
				$this->$ID_Thread = $row['ID_Thread'];
				$this->$Comment = $row['Comment'];
				$this->$Poster_Name = $row['Poster_Name'];
				$this->$ID_Flag = $row['ID_Flag'];
				$this->$Picture_Path = $row['Picture_Path'];
			}
		}
		
	}
?>