<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['type']) && isset($_POST['description']))
{
	// receiving the post params
	$type = $_POST['type'];
    $description = $_POST['description'];
	
	$db->addType($type, $description);
}
?>