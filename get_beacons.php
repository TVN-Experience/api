<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

// get the user by email and password
$data = $db->getBeacons();

if ($data != false) {
    // use is found
    echo json_encode($data);
}
else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "No beacons found";
    echo json_encode($response);
}
?>

