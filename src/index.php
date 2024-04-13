<?php

namespace App;

require_once __DIR__ . '/vendor/autoload.php';

$router = new Router();
$router->run($_SERVER['REQUEST_METHOD'], trim($_SERVER['REQUEST_URI'], '/'));
