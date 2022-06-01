<?php

return $routes = [
    'GET' => [
        'orders' => 'app/controllers/orders/read.php',
        'products' => 'app/controllers/products/read.php',
        'co2' => 'app/controllers/totCO2/read.php',
    ],
    'POST' => [
        'orders' => 'app/controllers/orders/create.php',
        'products' => 'app/controllers/products/create.php'
    ],
    'PUT' => [
        'orders' => 'app/controllers/orders/update.php',
        'products' => 'app/controllers/products/update.php'
    ],
    'DELETE' => [
        'orders' => 'app/controllers/orders/delete.php',
        'products' => 'app/controllers/products/delete.php'
    ]
];
