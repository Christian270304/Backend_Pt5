<?php
    // Christian Torres Barrantes
    require_once 'conexion.php';

     function idUsuario($username) {
        global $conn;
        $query = "SELECT id FROM users WHERE username = :username";
        $stmt = $conn->prepare($query);
        $stmt->execute([':username' => $username]);
        return $stmt->fetchColumn(); 
    }

    /*
        Funcion para insertar el nuevo articulo del usuario a la base de datos.
    */
    function insertar($titulo, $cuerpo,$user_id){
        global $conn;
        $query = "INSERT INTO articles (titol,cos,user_id) VALUES (:titol,:cos,:user_id)";
        $statement = $conn->prepare($query);
        $statement->execute( 
            array(
            ':titol' => $titulo, 
            ':cos' => $cuerpo,
            ':user_id' => $user_id)
        );
        
        if ($statement->rowCount() > 0) {
            $mensaje = "Se ha insertado correctamente";
        } else {
            $mensaje = "No se ha subido correctamente";
        }

        return $mensaje;
    }
?>