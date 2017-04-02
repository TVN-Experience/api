<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['id']) && isset($_POST['apartment_id']) && isset($_POST['description']))
{
	// receiving the post params
	$id = $_POST['id'];
    $apartment_id = $_POST['apartment_id'];
    $description = $_POST['description'];

	$db->addBeacon($id, $apartment_id, $description);
}
?>