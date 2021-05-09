<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


include_once '../../config/Database.php';
include_once '../../models/Contact.php';

//Instantiate DB and connect
$database = new Database();
$db = $database->connect();

//Instantiate contact object
$contact = new Contact($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Get ID
$contact->id = isset($_GET['id']) ? $_GET['id'] : die();

//Delete contact
if($contact->delete()) {
    echo json_encode(
        array('message' => 'Contact is deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Contact is not deleted.')
    );
}