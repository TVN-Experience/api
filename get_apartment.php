<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_GET['type_id'])) {

    // receiving the post params
    $id = $_GET['type_id'];

    // get the user by email and password
    $data = $db->getAppartment($id);

    if ($data != false) {
        // use is found
        echo json_encode($data);
    } 
} 
else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "No appartment found";
    echo json_encode($response);
}
?>

