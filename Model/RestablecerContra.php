<?php
    // Christian Torres Barrantes
    require_once 'conexion.php';

    // Obtener usuario por token
    function obtenerUsuarioPorToken($token) {
        global $conn;
        $query = "SELECT u.* FROM tokens t JOIN users u ON t.user_id = u.id WHERE t.token = :token AND t.expira > NOW()";
        $stmt = $conn->prepare($query);
        $stmt->execute([':token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar la contraseña del usuario
    function actualizarContrasena($id, $hashed_password) {
        global $conn;
        $stmt = $conn->prepare("UPDATE users SET password = :contra WHERE id = :id");
        $stmt->execute([':contra' => $hashed_password, ':id' => $id]);
    }

    // Borrar el token después de usarlo
    function borrarToken($token) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM tokens WHERE token = :token");
        $stmt->execute([':token' => $token]);
    }

    /**
 * Verifica si la nueva contraseña es la misma que la almacenada en la base de datos.
 * 
 * @param string $username El nombre de usuario del usuario.
 * @param string $nueva_contrasena La nueva contraseña proporcionada por el usuario.
 * @return bool Retorna true si la nueva contraseña es igual a la almacenada, false en caso contrario.
 */
function verificarContrasenaActual($username, $nueva_contrasena) {
    global $conn;

    // Obtener la contraseña encriptada del usuario
    $query = "SELECT password FROM users WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->execute([':username' => $username]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Comparar la nueva contraseña con la contraseña encriptada
        return password_verify($nueva_contrasena, $usuario['password']);
    }

    return false; // Usuario no encontrado o error en la consulta
}

function cerrarSesion() {
    global $conn;
    $user_id = idUsuario($_SESSION['username']);
    
    // Eliminar el token de la base de datos
    $stmt = $conn->prepare("DELETE FROM tokens WHERE user_id = :user_id");
    $stmt->execute([':user_id' => $user_id]);

    // Eliminar la cookie
    setcookie('session_token', '', time() - 3600, "/"); // Eliminar cookie

    // Cerrar sesión
    session_unset();
    session_destroy();
}

?>