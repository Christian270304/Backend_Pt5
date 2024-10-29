<?php
    require_once 'conexion.php';

    

    function subirImagen($rutaRelativa, $user_id) {
        global $conn;
        var_dump($user_id);
        // Preparar la consulta para actualizar la imagen del usuario
        $sql = "UPDATE users SET ruta_imagen = :ruta_imagen WHERE id = :id";
        $stmt = $conn->prepare($sql);
    
        // Ejecutar y verificar si se realizó el update correctamente
        $resultado = $stmt->execute([':ruta_imagen' => $rutaRelativa, ':id' => $user_id]);
    
        if ($resultado && $stmt->rowCount() > 0) {
            echo "Imagen actualizada correctamente en la base de datos.";
            return true;
        } else {
            echo "No se pudo actualizar la imagen en la base de datos. Verifica el ID del usuario.";
            return false;
        }
    }
?>