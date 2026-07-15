<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://www.koma-modular.be');

$name    = strip_tags(trim($_POST['name'] ?? ''));
$email   = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$phone   = strip_tags(trim($_POST['phone'] ?? ''));
$message = strip_tags(trim($_POST['message'] ?? ''));

if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$message) {
    echo json_encode(['ok' => false, 'error' => 'invalid']);
    exit;
}

$to      = 'pablo.even@koma-modular.be';
$cc      = 'filip.kovac@koma-modular.cz';
$subject = 'Contactformulier koma-modular.be — ' . $name;
$body    = "Naam: $name\nE-mail: $email\nTelefoon: $phone\n\n$message";
$headers = "From: noreply@koma-modular.be\r\nReply-To: $email\r\nCc: $cc";

$sent = mail($to, $subject, $body, $headers);
echo json_encode(['ok' => $sent]);
?>
