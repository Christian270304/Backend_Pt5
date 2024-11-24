<?php
    require_once 'Model/Usuarios.php';

    function eliminarCuenta($id,$eliminarArticle = false) {
        if ($eliminarArticle === 'true') {
            // Lógica para eliminar al usuario y sus artículos
            eliminarArticulosPorUsuario($id); // Función que debes implementar para eliminar artículos
        }
    
        if (eliminarUsuario($id)) {
            // Redirigir de nuevo a la página de administración de usuarios
            header("Location: index.php?pagina=Admin");
            exit();
        } else {
            echo "No se puede eliminar al usuario."; // Mensaje de error
        }
    }

?>