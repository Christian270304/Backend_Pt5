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
        if (empty($titol)) {
            $mensajes[] = 'El camp del titulo no pot estar buit';
        } 
        if (empty($cos)) {
            $mensajes[] = 'El camp del cos no pot estar buit';
        }
        
        if (empty($mensajes)){
            $id = selectId($titol,$cos);
            if ($id == null){
                $resultado = insertar($titol, $cos, $user_id);
                $mostrar .= '<div id="caja_mensaje" class="enviar">' . $resultado . '</div>';
            } else {
                $mensajes[] = 'Aquest article ja existeix';
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

    

?>
