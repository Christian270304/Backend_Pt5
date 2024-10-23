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
        Funcion para contar cuantos articulos hay dentro de la base de datos.
    */
    function countArticles($user_id) {
        global $conn; 
        $query = "SELECT COUNT(*) FROM articles WHERE user_id = :id"; 
        $stmt = $conn->prepare($query);
        $stmt->execute([':id' => $user_id]);
        
        return $stmt->fetchColumn(); 
    }

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
        Funcion para seleccionar un articulo mediante el id.
    */
    function selectOne($id){
        global $conn;
        $sql = "SELECT * FROM articles WHERE id = :id"; 
        $statement = $conn->prepare($sql); 
        $statement->execute([':id' => $id]); 
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result ? $result : null; // Retornar el resultado o null si no se encuentra
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
        Funcion para updatear el articulo que el usuario ha modificado.
    */
    function update($id,$titulo, $cuerpo){
        global $conn;
        $query = "UPDATE articles SET titol = :titol , cos = :cos WHERE id = :id"; 
        $statement = $conn->prepare($query); 
        $statement->execute([':titol' => $titulo, ':cos' => $cuerpo,':id' => $id]); 
        if ($statement->rowCount() > 0) {
            return "El artículo ha sido actualizado correctamente.";
        } else {
            return "No se pudo actualizar el artículo.";
        }
    }
?>