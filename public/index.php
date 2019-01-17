<?php

require  __DIR__ . '/../app/Utils/TwigLoader.php';
include __DIR__ . '/../app/Utils/AltoRouter.php';
include __DIR__ . '/../app/Utils/Database.php';
include __DIR__ . '/../app/Controllers/HomeController.php';
include __DIR__ . '/../app/Controllers/ShowController.php';
include __DIR__ . '/../app/Controllers/BookingController.php';
include __DIR__ . '/../app/Models/ShowModel.php';
include __DIR__ . '/../app/Models/BookingModel.php';

$configuration = parse_ini_file(
    __DIR__ . '/../app/config.ini',
    true
);


$router = new AltoRouter;

$router->setBasePath($configuration['router']['base_path']);

$router->map('GET', '/', 'HomeController#home', 'home');
$router->map('POST', '/show/add', 'ShowController#addShow', 'add_show');
$router->map('POST', '/show/delete', 'ShowController#deleteShow', 'delete_show');
$router->map('POST', '/show/edit', 'ShowController#editShow', 'edit_show');
$router->map('POST', '/booking/add', 'BookingController#addBooking', 'add_booking');
$router->map('POST', '/booking/show', 'BookingController#showBooking', 'show_booking');
$router->map('POST', '/booking/delete', 'BookingController#deleteBooking', 'delete_booking');

$match = $router->match();

if ($match === false) {
    $controller = new HomeController;
    $controller->page404();
} else {

    list($controllerName, $methodName) = explode('#', $match['target']);

    $controller = new $controllerName;

    $controller->$methodName();
}