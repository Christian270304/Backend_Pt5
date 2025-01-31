<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
require_once __DIR__ . '/libs/vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Data\QRMatrix;

$data = isset($_GET['text']) ? $_GET['text'] : '';

$options = new QROptions([
    'outputType'          => QRCode::OUTPUT_IMAGE_PNG,
    'quality'             => 100,
    'scale'               => 23,
    'outputBase64'        => true,
    'bgColor'             => [200, 150, 200],
    'imageTransparent'    => true,
    'drawCircularModules' => false,
    'drawLightModules'    => false,
    
]);

echo json_encode(['url' =>(new QRCode($options))->render($data)]);
?>