<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

// get the user by email and password
$data = $db->getApartments();

if ($data != false) {
    // use is found
    echo json_encode($data);
}
else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "No appartments found";
    echo json_encode($response);
}
?>

