<?php

//USER LOGIN
$router->get('/login', './controllers/user/index.php');
$router->get('/', './controllers/user/index.php');
$router->post('/login', './controllers/user/show.php');
$router->post('/logout', './controllers/user/logout.php');
$router->get('/yuwdaskjdbsamrmscusaijdscmasd21eeyuwqhd', './controllers/user/reset-password.php');

//DASHBOARD
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


//FLAVORS
$router->get('/flavors', './controllers/flavor/index.php');
$router->post('/flavors', './controllers/flavor/store.php');
$router->patch('/flavors', './controllers/flavor/update.php');
$router->delete('/flavors', controller: './controllers/flavor/destroy.php');


//ACCOUNTS
$router->get('/accounts', './controllers/account/index.php');
$router->get('/accounts/create', './controllers/account/create.php');
$router->post('/accounts', './controllers/account/store.php');
$router->patch('/accounts', './controllers/account/update.php');
$router->delete('/accounts', './controllers/account/destroy.php');
$router->patch('/accounts/transfer-ownership', './controllers/account/transfer-ownership.php');