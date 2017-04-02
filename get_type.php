<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['type_id'])) {

    // receiving the post params
    $id = $_POST['type_id'];

    // get the user by email and password
    $data = $db->getType($id);

    if ($data != false) {
        // use is found
        echo json_encode($data);
    } 
} 
else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "No type found";
    echo json_encode($response);
}
?>

