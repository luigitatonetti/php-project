<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'core/bootstrap.php';

$request = new APIRequest;
$request->decodeHttpRequest();
$data = $request->getBody();

$db = new db();
$db->openConnection($dbconfig);

$product = new Products($db);

if (
    !empty($data['id']) &&
    !empty($data['name']) &&
    !empty($data['co2']) 
) {
    if ($product->update($data)) {
        http_response_code(200);
        echo json_encode(array("message" => "Product updated"));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Cannot update product"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Missing data"));
}