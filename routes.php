<?php

//USER LOGIN
$router->get('/login', './controllers/user/index.php');
$router->get('/', './controllers/user/index.php');
$router->post('/login', './controllers/user/show.php');
$router->post('/logout', './controllers/user/logout.php');


$router->get('/dashboard', './controllers/dashboard/index.php');


//INVENTORY
$router->get('/inventory', './controllers/inventory/index.php');
$router->post('/inventory', './controllers/inventory/store.php');
$router->delete('/inventory', './controllers/inventory/destroy.php');
$router->patch('/inventory', './controllers/inventory/update.php');


//ORDERS
$router->get('/orders', './controllers/order/index.php');
$router->post('/orders', './controllers/order/store.php');
$router->patch('/orders', './controllers/order/update.php');


//ORDERS?FLAVORS
$router->get('/orders/flavors', './controllers/order/flavor/index.php');
$router->post('/orders/flavors', './controllers/order/flavor/store.php');
$router->patch('/orders/flavors', './controllers/order/flavor/update.php');
$router->delete('/orders/flavors', controller: './controllers/order/flavor/destroy.php');