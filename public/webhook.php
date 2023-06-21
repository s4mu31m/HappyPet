<?php
// Importar la biblioteca PHPMailer
use PHPMailer\PHPMailer;
use PHPMailer\Exception;
require_once '../vendor/autoload.php';


// Obtener el correo electrónico del cliente
$session = $event->data->object;
$customerEmail = $session->customer_details->email;

// Inicializar PHPMailer
$mail = new PHPMailer(true);


try {
    $mail->SMTPDebug = 2;                                 // Habilitar salida de depuración detallada
    $mail->isSMTP();                                      // Configurar el correo para usar SMTP
    $mail->Host = 'mail.happypet.uno';                    // Especificar el servidor SMTP
    $mail->SMTPAuth = true;                               // Habilitar autenticación SMTP
    $mail->Username = 'contacto@happypet.uno';             // Nombre de usuario del SMTP
    $mail->Password = '2ig%c9^B1*5^';                     // Contraseña del SMTP
    $mail->SMTPSecure = 'ssl';                            // Habilitar encriptación SSL
    $mail->Port = 465;                                    // Puerto SMTP

    //Destinatarios
    $mail->setFrom('contacto@happypet.uno', 'Mailer');
    $mail->addAddress($customerEmail, 'Joe User');     // Añadir destinatario

    // Contenido
    $mail->isHTML(true);                                  // Configurar formato de correo electrónico a HTML
    $mail->Subject = 'Confirmación de compra';
    $mail->Body    = 'Gracias por su compra. Aquí está la confirmación de su pedido...';
    $mail->AltBody = 'Gracias por su compra. Aquí está la confirmación de su pedido...';

    $mail->send();
    echo 'El mensaje se ha enviado';
} catch (Exception $e) {
    echo 'El mensaje no pudo ser enviado. Error de correo: ', $mail->ErrorInfo;
}
