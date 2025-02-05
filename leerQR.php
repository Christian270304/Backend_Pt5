<?php
//session_start();

require_once __DIR__ . '/libs/vendor/autoload.php';

use chillerlan\QRCode\QRCode;

$maxFileSize = 10 * 1024; // 2MB
$fileTmpPath = $_FILES['qrImage']['tmp_name'];
$fileType = mime_content_type($fileTmpPath);

// Verifica que el archivo sea una imagen PNG
if ($fileType !== 'image/png') {
    $error = "El archivo no es una imagen PNG";
    include_once 'Html/LeerQR.php';
    exit;
} 
 if (filesize($fileTmpPath) > $maxFileSize) {
    $error = "El archivo es demasiado grande. El tamaño máximo permitido es de 2MB.";
    include_once 'Html/LeerQR.php';
    exit;
}

try {
    $result = (new QRCode)->readFromFile($fileTmpPath); // -> DecoderResult

    // you can now use the result instance...
    $content = trim($result->data); // Elimina espacios en blanco al inicio y al final
   

    // Expresión regular para validar que el contenido comience con la URL fija
    $pattern = '/^https:\/\/www\.ctorres\.cat\/index\.php\?pagina=Login&username=([^&]+)/';
    if (preg_match($pattern, $content, $matches)) {
        

        // Extrae el nombre de usuario del contenido
        $username = $matches[1];
        
        // Verifica si el usuario tiene la sesión iniciada
        if (isset($_SESSION['username'])) {
            $redirectUrl = "https://www.ctorres.cat/index.php?pagina=UserProfile&username=" . urlencode($username);
            header('Location: ' . $redirectUrl);
            exit;
        } else {
            header('Location: ' . $content);
            exit;
        }
    } else {
        $error = "El contenido del QR no es válido";
        include_once 'Html/LeerQR.php';
    }
    exit;
} catch (Throwable $exception) {
    $error = "Algo ha ido mal al leer el QR";
    include_once 'Html/LeerQR.php';
}
?>