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

    /*
        Funcion para seleccionar el id de un articulo mediante el titulo y el cuerpo.
    */
    function selectId($titol,$cos){
        global $conn;
        $sql = "SELECT id FROM articles WHERE titol = :titol AND cos = :cos"; // Sentencia sql.
        $statement = $conn->prepare($sql); // Preparar la sentencia.
        $statement->execute([':titol' => $titol,':cos' => $cos]); // Ejecutar la consulta.  
        $result = $statement->fetch(PDO::FETCH_ASSOC); // Obtener el resultado como un array asociativo.
        return $result ? $result['id'] : null; // Verificar si hay resultados y devolver el ID, o null si no se encuentra.
    }
?>