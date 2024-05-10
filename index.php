<?php
declare(strict_types=1);

require dirname(__DIR__) . "/api/vendor/autoload.php";

// error handler
set_exception_handler("\\ErrorHandler::handleException");

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

$database = new Database("localhost", "api_db", "root", "root");

$database->getConnection();

$controller = new TaskController;
$controller->processRequest($_SERVER['REQUEST_METHOD'], $id);
