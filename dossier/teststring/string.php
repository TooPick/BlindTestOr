<?php 
	function compareTo ($answer , $submission) {
		$article = ["le", "la", "les", "the"];

		if (substr_compare($answer, $submission, 0, strlen($answer), true) != 0) {
			$one = explode(" ", $answer, 2);
			
			if(in_array(strtolower($one[0]), $article)) {
				$result = substr_compare($one[1],$submission, 0, strlen($one[1]),true);
				if($result == 0)
					return true;
				else 
					return false;
			}
			else
				return false;
		}
		else 
			return true;
	}

	echo (compareTo("Lles Fatals Picards", "Lles faTaLs PiCards"));

?>