<?php
    // Christian Torres Barrantes
    require_once 'conexion.php';


    function selectUsuario($user_id){
        global $conn;
        $query = "SELECT * FROM articles WHERE user_id = :user_id";
        $statement = $conn->prepare($query);
        $statement->execute([':user_id' => $user_id]);
        $resultado = $statement->fetchAll();
        $articles = [];
        foreach ($resultado as $row) {
            $articles[] = [
                'id' => $row['id'],
                'titol' => $row['titol'],
                'cos' => $row['cos']
            ];
        }
        return $articles;
    }

    /*
        Funcion para borrar el articulo que ha seleccionado el usuario mediante el id.
    */
    function borrarArticle($id){
        global $conn;
        if (!$conn) {
            die("Error de conexión: ");
        }
        $sql = "DELETE FROM articles WHERE id = :id"; 
        $stmt = $conn->prepare($sql); 
        $stmt->execute([':id' => $id]); 
        if ($stmt->rowCount() > 0) {
            return "Se ha Borrado Correctamente";
        } else {
            return "Error al borrar el artículo";
        }
    }

    /*
        Funcion para contar cuantos articulos hay dentro de la base de datos.
    */
    function countArticles($user_id) {
        global $conn; 
        $query = "SELECT COUNT(*) FROM articles WHERE user_id = :id"; 
        $stmt = $conn->prepare($query);
        $stmt->execute([':id' => $user_id]);
        
        return $stmt->fetchColumn(); 
    }

     /*
        Funcion para agarrar el titulo y el cuerpo de un articulo mediante su id.
    */
    function selectTitolCos($id){
        global $conn;
        $query = "SELECT titol,cos FROM articles WHERE id = :id";
        $statement = $conn->prepare($query); 
        $statement->execute([':id' => $id]); 
        $resultado = $statement->fetchAll();
        $articles = [];
        foreach ($resultado as $row) {
            $articles[] = [
                'titol' => $row['titol'],
                'cos' => $row['cos']
            ];
        }
        return $articles;
    }

    /*
        Funcion para seleccionar el id de un articulo mediante el titulo y el cuerpo.
    */
    function selectId($titol,$cos){
        global $conn;
        $sql = "SELECT id FROM articles WHERE titol = :titol AND cos = :cos"; 
        $statement = $conn->prepare($sql); 
        $statement->execute([':titol' => $titol,':cos' => $cos]);  
        $result = $statement->fetch(PDO::FETCH_ASSOC); 
        return $result ? $result['id'] : null; 
    }

    /**
     * Funcion para buscar el id de un usuario mediante el username.
     */
    function idUsuario($username) {
        global $conn;
        $query = "SELECT id FROM users WHERE username = :username";
        $stmt = $conn->prepare($query);
        $stmt->execute([':username' => $username]);
        return $stmt->fetchColumn(); 
    }

    /*
        Funcion para seleccionar un articulo mediante el id.
    */
    function selectOne($id){
        global $conn;
        $sql = "SELECT * FROM articles WHERE id = :id"; 
        $statement = $conn->prepare($sql);
        $statement->execute([':id' => $id]); 
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result ? $result : null; 
    }
?>