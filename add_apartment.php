<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['type_id']) && isset($_POST['measurements']) && isset($_POST['description']) && isset($_POST['floors']))
{
	// receiving the post params
	$type_id = $_POST['type_id'];
    $measurements = $_POST['measurements'];
    $description = $_POST['description'];
    $floors = $_POST['floors'];

	$db->addApartment($type_id, $measurements, $description, $floors);
}
?>