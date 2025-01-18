<?php
include 'config.php';
// Log the webhook request to a file for debugging
//file_put_contents('webhook.log', file_get_contents('php://input') . "\n", FILE_APPEND);
 
// Read the incoming POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);
 
if ($data) {
    // Process the data as needed
    // For example, you can log the data or store it in a  database
    $orderid=$data['data']['order']['order_id'];
    $payment_time=$data['data']['payment']['payment_time'];
    $orderStatus=$data['data']['payment']['payment_status'];
    
    /******** update payment Status **********/
    //write your database update query here
 
/************** end payment status ***************/
 
 
   // file_put_contents('data.log', print_r($data, true), FILE_APPEND);
 
    // Respond to the webhook sender
    http_response_code(200);
    echo json_encode(['status' => 'success']);
} else {
    // Invalid data
    http_response_code(400);
    echo json_encode(['status' => 'invalid data']);
}
?>