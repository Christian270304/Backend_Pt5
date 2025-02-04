<?php
// Christian Torres Barrantes

require_once 'Model/SubirImagen.php';

$mensajes = [];
$mostrar = '';

// Verificar si se ha subido un archivo para la imagen de perfil
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['profile_image']['tmp_name'];
    $fileName = $_FILES['profile_image']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileExtension, $allowedExtensions)) {
        $newFileName = uniqid() . '.' . $fileExtension;
        $uploadFileDir = './uploads/';
        $destPath = $uploadFileDir . $newFileName;

        // Crear el directorio si no existe
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }

        // Mover el archivo al directorio
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            // Guardar la ruta en la base de datos
            $rutaRelativa = $destPath;  // O usa una URL completa si es necesario
            $id = idUsuario($_SESSION['username']);
            $resultado = subirImagen($rutaRelativa, $id);
           
            if ($resultado === TRUE) {
                // Guardar la ruta en la sesión
                $_SESSION['profile_image'] = $destPath;
                header("Location: index.php?pagina=Perfil"); // Redirigir al perfil
                exit;
            } else {
                $mensajes[] = "Error al guardar la ruta en la base de datos: ";
            }
        } else {
            $mensajes[] = "Hubo un error al mover el archivo.";
        }
    } else {
        $mensajes[] = "Tipo de archivo no permitido. Solo se permiten imágenes JPG, JPEG, PNG y GIF.";
    }
} else {
    $mensajes[] = "No se subió ningún archivo o hubo un error en la carga.";
}

// Generar mensajes de error
if (!empty($mensajes)) {
    $mostrar .= '<div id="caja_mensaje" class="errors">';
    foreach ($mensajes as $mensaje) {
        $mostrar .= $mensaje . '<br/>';
    }
    $mostrar .= '</div>';
}
