<?php

$choices = $_POST['genre'];

if(is_array($choices)){
	foreach ($choices as $choice){ 
		echo $choice."<br />";
	}
}else{
	
	echo $choices."<br />";
}
?>