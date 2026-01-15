<?php
error_reporting(0);
ini_set('display_errors', 0);

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

require_once __DIR__ . '/api/controllers/TaskController.php';
require_once __DIR__ . '/api/utils/Response.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/public', '', $uri);
$uri = trim($uri, '/');

if ($uri === '') {
    Response::success(null, 'Todo API is running');
}

$segments = explode('/', $uri);
$controller = new TaskController();

if ($segments[0] === 'tasks') {

    $id = isset($segments[1]) && is_numeric($segments[1])
        ? (int)$segments[1]
        : null;

    switch ($method) {
        case 'GET':
            $id ? $controller->show($id) : $controller->index();
            break;

        case 'POST':
            $controller->store();
            break;

        case 'PUT':
            if (!$id) Response::error('Task ID is required', 400);
            $controller->update($id);
            break;

        case 'DELETE':
            if (!$id) Response::error('Task ID is required', 400);
            $controller->destroy($id);
            break;

        default:
            Response::error('Method not allowed', 405);
    }

} else {
    Response::error('Endpoint not found', 404);
}
