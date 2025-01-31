<?php

require_once __DIR__ . '/libs/vendor/autoload.php';

use chillerlan\QRCode\QRCode;
$fileTmpPath = $_FILES['qrImage']["tmp_name"];

    try {

        $result = (new QRCode)->readFromFile($fileTmpPath); // -> DecoderResult

        // you can now use the result instance...
        $content = $result->data;

	    header('Location: ' . $content);

    } catch (Throwable $exception) {
        var_dump($exception);
    }

?>