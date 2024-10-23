<?php
// Christian Torres Barrantes
require_once 'PHPMailer\PHPMailer\PHPMailer.php';
require_once 'PHPMailer\PHPMailer\SMTP.php';
require_once 'PHPMailer\PHPMailer\Exception.php';
use PHPMailer\PHPMailer\PHPMailer;

// Crea una nueva instancia de PHPMailer, con true decimos que queremos generar excepciones si ocurren
$mail = new PHPMailer(true);

// Configuración del servidor
$mail->isSMTP();                                      // Establece el tipo de correo electrónico para usar SMTP
$mail->Host = 'smtp.gmail.com';                     // Especifica los servidores SMTP principales y de respaldo
$mail->SMTPAuth = true;                               // Habilita la autenticación SMTP
$mail->Username = 'backendpruebas04@gmail.com';                   // Nombre de usuario SMTP
$mail->Password = 'xrwa gkrn bpmf gzmb';                   // Contraseña SMTP
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Habilita el cifrado TLS; `ssl` también aceptado
$mail->Port = 587;                                    // Puerto TCP para conectarse

try {
    // Configura y envía el mensaje
    $mail->setFrom('no-reply@tudominio.com');
    $mail->addAddress($correo);
    $mail->Subject = "Mensaje";
    $mail->Body = $mensaje;
    $mail->send();
} catch (Exception $e) {
    //echo 'El mensaje no pudo ser enviado.';
    //echo 'Error de correo: ' . $mail->ErrorInfo;
}