<?php

require_once '../vendor/autoload.php';
require_once '../secrets.php';

use PHPMailer\PHPMailer\PHPMailer;

\Stripe\Stripe::setApiKey($stripeWebhookSigningSecret);

$payload = @file_get_contents('php://input');
$event = null;

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload,
        $_SERVER['HTTP_STRIPE_SIGNATURE'],
        $stripeWebhookSecret
    );
} catch (\UnexpectedValueException $e) {
    // Invalid payload
    http_response_code(400);
    exit();
} catch (\Stripe\Exception\SignatureVerificationException $e) {
    // Invalid signature
    http_response_code(400);
    exit();
}

// Handle the event
switch ($event->type) {
    case 'checkout.session.completed':
        handleCheckoutSessionCompleted($event->data->object);
        break;
        // ... handle other event types
    default:
        // Unexpected event type
        http_response_code(400);
        exit();
}


http_response_code(200);

function handleCheckoutSessionCompleted($session)
{
    $customerID = $session->customer; // get the customer ID
    $customer = \Stripe\Customer::retrieve($customerID); // retrieve the customer information using the customer ID
    $product = $session->line_items->data[0]->description;
    $price = $session->line_items->data[0]->amount_total / 100;

    $customerEmail = $customer->email; // get the customer email
    $customerName = $customer->name; // get the customer name
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'mail.happypet.uno';  // especifica el servidor SMTP
    $mail->SMTPAuth = true;                               // habilita la autenticación SMTP
    $mail->Username = 'contacto@happypet.uno'; // tu dirección de correo
    $mail->Password = '2c%f1iD$(#46'; // la contraseña de tu correo
    $mail->SMTPSecure = 'ssl';                            // habilita la encriptación TLS, `ssl` también es aceptado
    $mail->Port = 465;                                    // puerto TCP para conectarse

    //Recipients
    $mail->setFrom('contacto@happypet.uno', 'HappyPet'); // el correo y nombre que aparecerá como remitente
    $mail->addAddress($customerEmail, $customerName); // el correo y nombre del destinatario

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Compra Exitosa en HappyPet';
    $mail->Body    = 'Hola, <br> Gracias por tu compra en HappyPet. Adquiriste el producto ' . $product . ' por el precio de ' . $price . '. <br> ¡Esperamos que lo disfrutes!';
    $mail->AltBody = 'Hola, Gracias por tu compra en HappyPet. Adquiriste el producto ' . $product . ' por el precio de ' . $price . '. ¡Esperamos que lo disfrutes!';

    try {
        $mail->send();
        echo 'El mensaje ha sido enviado';
    } catch (Exception $e) {
        echo 'El mensaje no pudo ser enviado. Mailer Error: ', $mail->ErrorInfo;
    }
}
