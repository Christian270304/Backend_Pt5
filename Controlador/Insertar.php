<?php 
    // Christian Torres Barrantes
    require_once 'Model/Insertar.php';

    /*
        Funcion para poder insertar los articulos a la base de datos.
        $titulo = El titulo del articulo 
        $cuerpo = El cuerpo de
    */
    function insertarDatos($titulo,$cuerpo){
        $mensajes= array();
        $mostrar = '';
        $user_id = idUsuario($_SESSION['username']);

        $titol = isset($titulo) ? trim(htmlspecialchars($titulo)) : '';
        $cos = isset($cuerpo) ? trim(htmlspecialchars($cuerpo)) : '';
        var_dump($titol);
        if (empty($titol)) {
            $mensajes[] = 'El campo del titulo no puede estar vacio';
        } 
        if (empty($cos)) {
            $mensajes[] = 'El campo del cuerpo no puede estar vacio';
        }
        
        if (empty($mensajes)){
            $id = selectId($titol,$cos);
            if ($id == null){
                $resultado = insertar($titol, $cos, $user_id);
                $mostrar .= '<div id="caja_mensaje" class="enviar">' . $resultado . '</div>';
            } else {
                $mensajes[] = 'Este articulo ya existe';
            }
        }
        
        
        // Generar mensajes de error
        if (!empty($mensajes)) {
            $mostrar .= '<div id="caja_mensaje" class="errors">';
            foreach ($mensajes as $mensaje) {
                $mostrar .= $mensaje . '<br/>';
            }
            $mostrar .= '</div>';
        } 
        
        include 'Html/Insertar.php';
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
