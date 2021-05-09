<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Contact.php';

//Instantiate DB and connect
$database = new Database();
$db = $database->connect();

//Instantiate contact object
$contact = new Contact($db);

//Get ID
$contact->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get contact
$contact->read();

//Create array
$contact_arr = array(
    'id' => $contact->id,
    'name' => $contact->name,
    'phone' => $contact->phone,
    'address' => $contact->address,
    'created_at' => $contact->created_at
);

//Make JSON
print_r(json_encode($contact_arr));

//http://localhost/newapp/api/contact/read.php?id=1