<?php
// Set headers for CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

require_once './../config/database.php';
require_once './Routing.php';
require_once './../src/controllers/UserController.php';
require_once './../src/controllers/PostController.php';

// Decode the JSON input
$data = json_decode(file_get_contents('php://input'), true);

$router = new Router();

// Define routes
$router->add('/', function() {
    echo json_encode("No function");
});

// Make sure the class name matches the controller file
$router->add('createUser', 'UserController@createUser');
$router->add('getUserById', 'UserController@getUserById');
$router->add('login', 'UserController@login');


$router->add('createPost', 'PostController@createPost');


// Run the router if data is provided
if ($data != null) {
    header('Content-Type: application/json');
    $router->run($data["uri"], $db, $data["values"]);
} else {
    echo json_encode(["error" => "No input data provided."]);
}


?>