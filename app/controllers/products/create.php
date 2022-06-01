<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'core/bootstrap.php';

$request = new APIRequest;
$request->decodeHttpRequest();
$data = $request->getBody();

$db = new db();
$db->openConnection();

$product = new Products($db);

if (
    !empty($data['name']) &&
    !empty($data['co2'])
) {
    if ($product->create($data)) {
        http_response_code(201);
        echo json_encode(array("message" => "Product added"));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Cannot add product"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Missing data"));
}
