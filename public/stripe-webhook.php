<?php

require_once '../vendor/autoload.php';
require_once '../secrets.php';

\Stripe\Stripe::setApiKey($stripeSecretKey);

$payload = @file_get_contents('php://input');
$event = null;

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload, $_SERVER['HTTP_STRIPE_SIGNATURE'], $stripeWebhookSecret
    );
} catch(\UnexpectedValueException $e) {
    // Invalid payload
    http_response_code(400);
    exit();
} catch(\Stripe\Exception\SignatureVerificationException $e) {
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

function handleCheckoutSessionCompleted($session) {
    $customerEmail = $session->customer_details->email;
    // Aquí deberás incluir el código para enviar un correo de confirmación al cliente.
    // Puedes usar la función mail() de PHP, o un servicio de mailing como PHPMailer, Sendgrid, etc.
}
