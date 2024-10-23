<?php 
    // Christian Torres Barrantes
    require_once 'conexion.php';

    /**
     * Funcion para seleccionar todos los articulos del usuario que le pasamos por parametro.
     */
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
        Funcion para contar cuantos articulos hay dentro de la base de datos.
    */
    function countArticles($user_id) {
        global $conn; 
        $query = "SELECT COUNT(*) FROM articles WHERE user_id = :id"; 
        $stmt = $conn->prepare($query);
        $stmt->execute([':id' => $user_id]);
        
        return $stmt->fetchColumn(); 
    }

    /**
     * Funcion para agarrar el id del usuario mediante su username.
     */
    function idUsuario($username) {
        global $conn;
        $query = "SELECT id FROM users WHERE username = :username";
        $stmt = $conn->prepare($query);
        $stmt->execute([':username' => $username]);
        return $stmt->fetchColumn(); 
    }
?>