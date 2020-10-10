<?php 

function debug_to_console($data) {
	$output = $data;
	echo "<script>console.log(JSON.parse('" . json_encode($output) . "') );</script>";
}


?>