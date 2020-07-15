<?php

function displayErrors($errs){
	echo "<div>\n";
	echo "<h3> This form contains the following errors</h3>\n";
	echo "<ul class='error'>\n";
	foreach ($errs as $err){
		echo "<li>".$err."</li>\n";
	}
	echo "</ul>\n";
	echo "</div>\n";
}

function checkSelectedContact(){
    $err_msgs = array();
    if (!isset($_POST['list_select'])){
        $err_msgs[] = "No contact selected on the list";
    } 
    return $err_msgs;
}

?>


