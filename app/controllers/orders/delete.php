<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'core/bootstrap.php';

$request = new APIRequest;
$request->decodeHttpRequest();
$data = $request->getBody();

$db = new db();
$db->openConnection($dbconfig);

$order = new Orders($db);

if (!empty($data['id'])) {
    if ($order->delete($data)) {
        http_response_code(200);
        echo json_encode(array("message" => "Order deleted"));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Cannot delete the order"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Missing data"));
}
