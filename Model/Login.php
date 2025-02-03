<?php
    // Christian Torres Barrantes
    require_once 'conexion.php';
    // Buscar un usuario por nombre de usuario
    function buscarUsuario($username) {
        global $conn;
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $conn->prepare($query);
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function guardarToken($userId, $token) {
        global $conn;
        $expira = date("Y-m-d H:i:s", strtotime('+30 days')); // Expira en 30 días
        $stmt = $conn->prepare("INSERT INTO tokens (user_id, token, expira) VALUES (:user_id, :token, :expira)");
        $stmt->execute([':user_id' => $userId, ':token' => $token, ':expira' => $expira]);
    }

    function buscarUsuarioPorToken($token) {
        global $conn;
        $stmt = $conn->prepare("
            SELECT users.* 
            FROM users 
            JOIN tokens ON users.id = tokens.user_id 
            WHERE tokens.token = :token
        ");
        $stmt->execute([':token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function articulosUsuario($username) {
        global $conn;
        $query = "SELECT articles.*
                        FROM articles
                        INNER JOIN users ON articles.user_id = users.id
                        WHERE users.username = :username";
            $statement = $conn->prepare($query);
            $statement->bindParam(':username', $username, PDO::PARAM_STR);
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
?>