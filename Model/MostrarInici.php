<?php 
    // Christian Torres Barrantes
    require_once 'conexion.php';
    /*
        Funcion para agarrar todos los campos de articles en la base de datos.
    */
    function select($searchQuery = ''){
        global $conn;
        $query = "SELECT * FROM articles WHERE titol RLIKE :searchQuery OR cos RLIKE :searchQuery";
        $statement = $conn->prepare($query);
        $statement->bindParam(':searchQuery',$searchQuery, PDO::PARAM_STR);
        $statement->execute();
        $resultado = $statement->fetchAll();
        $articles = [];
        foreach ($resultado as $row) {
            $articles[] = [
                'id' => $row['id'],
                'titol' => $row['titol'],
                'cos' => $row['cos'],
                'ruta_imagen' => $row['ruta_imagen']
            ];
        }
        return $articles;
    }

    function nomUsuari($article_id){
        global $conn;
        $query = "SELECT users.username
                  FROM articles
                  JOIN users ON articles.user_id = users.id
                  WHERE articles.id = :article_id";
        $statement = $conn->prepare($query);
        $statement->bindParam(':article_id',$article_id, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchColumn();
    }

    /*
        Funcion para contar cuantos articulos hay dentro de la base de datos.
    */
    function countArticles() {
        global $conn; 
        $query = "SELECT COUNT(*) FROM articles"; 
        $stmt = $conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchColumn(); 
    }
?>