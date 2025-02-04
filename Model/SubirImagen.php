<?php
    require_once 'conexion.php';

    

    function subirImagen($rutaRelativa, $user_id) {
        global $conn;
        // Preparar la consulta para actualizar la imagen del usuario
        $sql = "UPDATE users SET ruta_imagen = :ruta_imagen WHERE id = :id";
        $stmt = $conn->prepare($sql);
    
        // Ejecutar y verificar si se realizó el update correctamente
        $resultado = $stmt->execute([':ruta_imagen' => $rutaRelativa, ':id' => $user_id]);
    
        if ($resultado && $stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function subirImagenArticle($rutaRelativa, $article_id) {
        global $conn;
        // Preparar la consulta para actualizar la imagen del usuario
        $sql = "UPDATE users SET ruta_imagen = :ruta_imagen WHERE id = :id";
        $stmt = $conn->prepare($sql);
    
        // Ejecutar y verificar si se realizó el update correctamente
        $resultado = $stmt->execute([':ruta_imagen' => $rutaRelativa, ':id' => $article_id]);
    
        if ($resultado && $stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
?>