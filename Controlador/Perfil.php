<?php
    // Christian Torres Barrantes

    require_once 'Model/Perfil.php';

    function mostrarEmail() {
        $user_id = idUsuario($_SESSION['username']);
        $email = email($user_id);
        
        return $email;
    }
?>