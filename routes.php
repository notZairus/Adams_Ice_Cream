<?php

//USER LOGIN
$router->get('/login', './controllers/user/index.php');
$router->get('/', './controllers/user/index.php');
$router->post('/login', './controllers/user/show.php');
$router->post('/logout', './controllers/user/logout.php');


$router->get('/dashboard', './controllers/dashboard.php');


//INVENTORY
$router->get('/inventory', './controllers/inventory/index.php');
$router->post('/inventory', './controllers/inventory/store.php');
$router->delete('/inventory', './controllers/inventory/destroy.php');
$router->patch('/inventory', './controllers/inventory/update.php');


//ORDER
$router->get('/orders', './controllers/order/index.php');
$router->post('/orders', './controllers/order/store.php');