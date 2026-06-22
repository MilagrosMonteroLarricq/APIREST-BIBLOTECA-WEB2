<?php

require_once 'libs/router/router.php';
require_once 'libs/jwt/jwt.middleware.php';
require_once 'app/controllers/libros.controller.php';
require_once 'app/controllers/auth.controller.php';

//crear router
$router = new Router();

//tablas de rutas
$router->addRoute('libros', 'GET', 'LibrosController', 'getLibros');
$router->addRoute('libros/:id', 'GET', 'LibrosController', 'getLibroById');
$router->addRoute('libros', 'POST', 'LibrosController', 'insertLibro');
$router->addRoute('libros/:id', 'PUT', 'LibrosController', 'updateLibro');
$router->addRoute('libros/:id', 'DELETE', 'LibrosController', 'removeLibro');
$router->addRoute('auth/token', 'POST', 'AuthController', 'login');


//ejecuta la ruta correspondiente
$resource = $_GET["resource"] ?? '';
$resource = trim($resource, '/');
$router->route($resource, $_SERVER['REQUEST_METHOD']);

