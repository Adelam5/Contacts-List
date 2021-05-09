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

//Contact query
$result = $contact->readAll();

//Get new row
$num = $result->rowCount();

//Check if any contacts
if($num > 0) {
    //Contact array
    $contacts_arr = array();
    $contacts_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $contact_item = array(
            'id' => $id,
            'name' => $name,
            'phone' => $phone,
            'address' => $address,
            'created_at' => $created_at
        );
        // Push to "data"
        array_push($contacts_arr['data'], $contact_item);
    }
    //Turn to JSON and output
    echo json_encode($contacts_arr);
} else {
    //No Contacts
    echo json_encode(
        array('message' => 'No Contacts Found')
    );
}