<?php
declare(strict_types=1);

use Dotenv\Dotenv;

// autoload
require dirname(__DIR__) . "/api/vendor/autoload.php";

// error handler
set_exception_handler("\\ErrorHandler::handleException");

// load env data
$dotenv = Dotenv::createImmutable(dirname(__DIR__) . "/api");
$dotenv->load();

// parse url request
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$parts = explode("/", $path);
$resource = $parts[2];
$id = $parts[3] ?? null;

// create response codes
if ($resource != 'tasks') {
    // header("HTTP/1.1 404 Not Found");
    http_response_code(404); // recommended way to use response codes
    exit;
}

// set to return JSON Content Type
header("Content-Type: application/json; charset=UTF-8");

// create and load Database connection
$database = new Database($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);
$database->getConnection();

$task_gateway = new TaskGateway($database);

// work with taskController
$controller = new TaskController($task_gateway);
$controller->processRequest($_SERVER['REQUEST_METHOD'], $id);
