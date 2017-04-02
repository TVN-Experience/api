<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['beacon_id']) && isset($_POST['start_time']) && isset($_POST['end_time']) && isset($_POST['mac_address']))
{
    // receiving the post params
    $beacon_id = $_POST['beacon_id'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $mac_address = $_POST['mac_address'];

    $db->addTracking($beacon_id, $start_time, $end_time, $mac_address );
}
?>
?>