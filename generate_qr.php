<?php
require_once __DIR__ . '/libs/vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\QROutputInterface;

$data = isset($_GET['text']) ? $_GET['text'] : '';

$options = new QROptions([
    'outputType'          => QROutputInterface::GDIMAGE_PNG,
    'quality'             => 100,
    'scale'               => 5,
    'outputBase64'        => true,
    'bgColor'             => [200, 150, 200],
    'imageTransparent'    => true,
    'drawCircularModules' => false,
    'drawLightModules'    => false,
    'moduleValues'        => [
        QRMatrix::M_FINDER_DARK    => [0, 63, 255], // dark (true)
        QRMatrix::M_FINDER_DOT     => [0, 63, 255], // finder dot, dark (true)
        QRMatrix::M_FINDER         => [233, 233, 233], // light (false)
        QRMatrix::M_ALIGNMENT_DARK => [255, 0, 255],
        QRMatrix::M_ALIGNMENT      => [233, 233, 233],
        QRMatrix::M_DATA_DARK      => [0, 0, 0],
        QRMatrix::M_DATA           => [233, 233, 233],
    ],
]);

echo json_encode(['url' =>(new QRCode($options))->render($data)]);
?>