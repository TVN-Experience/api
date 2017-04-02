<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['uri']))
{
    // receiving the post params
    $uri = $_POST['uri'];

    $db->addImage($uri);
}
?>