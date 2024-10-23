<?php 
    // Christian Torres Barrantes
    require_once 'conexion.php';
    /*
        Funcion para agarrar todos los campos de articles en la base de datos.
    */
    function select(){
        global $conn;
        $query = "SELECT * FROM articles";
        $statement = $conn->prepare($query);
        $statement->execute();
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
    function countArticles() {
        global $conn; 
        $query = "SELECT COUNT(*) FROM articles"; 
        $stmt = $conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchColumn(); 
    }
?>