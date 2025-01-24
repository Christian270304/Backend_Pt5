<?php
require_once 'api/controllers/ApiController.php';

$uri = str_replace('/Backend_Pt5/api/', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Use regex to capture the endpoint and the parameter
if (preg_match('/^(\w+)(\/(\d+))?$/', $uri, $matches)) {
    $endpoint = $matches[1];
    $param = isset($matches[3]) ? $matches[3] : null;

    $controller = new ApiController();

    switch ($endpoint) {
        case 'getuser':
            $controller->getUser($param); // Pass the parameter to the controller method
            break;
        case 'getusers':
            $controller->getUsers(); // Pass the parameter to the controller method
            break;
        case 'getarticle':
            $controller->getArticle($param); // No parameter needed for this method
            break;
        case 'getarticles':
            $controller->getArticles(); // No parameter needed for this method
            break;
        default:
            header("HTTP/1.0 404 Not Found");
            echo json_encode(['error' => 'API endpoint not found']);
            break;
    }
} else {
    header("HTTP/1.0 404 Not Found");
    echo json_encode(['error' => 'Invalid API endpoint']);
}
exit; // Ensure no further code is executed for API requests
?>