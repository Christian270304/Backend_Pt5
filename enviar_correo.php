<?php
// Christian Torres Barrantes
require_once 'libs\PHPMailer\PHPMailer\PHPMailer.php';
require_once 'libs\PHPMailer\PHPMailer\SMTP.php';
require_once 'libs\PHPMailer\PHPMailer\Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Crea una nueva instancia de PHPMailer, con true decimos que queremos generar excepciones si ocurren
$mail = new PHPMailer(true);

try {
    // Configuración del servidor
    $mail->isSMTP();                                      // Establece el tipo de correo electrónico para usar SMTP
    $mail->Host = 'smtp.dondominio.com';                     // Especifica los servidores SMTP principales y de respaldo
    $mail->SMTPAuth = true;                               // Habilita la autenticación SMTP
    $mail->Username = MAIL;                   // Nombre de usuario SMTP
    $mail->Password = PASS_MAIL;                   // Contraseña SMTP
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Habilita el cifrado TLS; `ssl` también aceptado
    $mail->Port = 587;                                    // Puerto TCP para conectarse

    // Establecer la codificación de caracteres
    $mail->CharSet = 'UTF-8'; // Establece la codificación de caracteres a UTF-8
    
    // Destinatario
    $mail->setFrom('no-reply@ctorres.cat');
    $mail->addAddress($correo);

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = $asunto;
    $mail->Body = $mensaje;
    //$mail->AltBody = "Hola!\nHemos recibido una solicitud para restablecer la contraseña de tu cuenta.\nPara restablecer tu contraseña, haz clic en el siguiente enlace: http://localhost/Practica-04/index.php?pagina=Restablecer&token=$token\nSi no solicitaste un restablecimiento de contraseña, simplemente puedes ignorar este correo.\nGracias,\nEl equipo de soporte.";
    $mail->send();
} catch (Exception $e) {
    //echo 'El mensaje no pudo ser enviado.';
    //echo 'Error de correo: ' . $mail->ErrorInfo;
}