<?php
require_once 'api/controllers/ApiController.php';
require_once 'api/Middleware.php';



//$uri = $_SERVER['REQUEST_URI'];
//$base_path = "/Backend_Pt5/api/"; // Ajusta según tu carpeta
$uri = str_replace('/Backend_Pt5/api/', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$usuario = authenticate();

// Use regex to capture the endpoint and the parameter
if (preg_match('/^(\w+)(\/(\d+))?$/', $uri, $matches)) {
    $endpoint = $matches[1];
    $param = isset($matches[3]) ? $matches[3] : null;

    $controller = new ApiController();

    switch ($endpoint) {
        case 'getuser':
            $controller->getUser($param);
            break;
        case 'getusers':
            $controller->getUsers();
            break;
        case 'getarticle':
            $controller->getArticle($param);
            break;
        case 'getarticles':
            $controller->getArticles();
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
exit;
?>