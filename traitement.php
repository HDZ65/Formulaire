<?php

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$message = $_POST['message'];

$recaptcha = new \ReCaptcha\ReCaptcha("6LeIA7opAAAAABO28ghXPsNj0wFxhqk9cXGCouDo");
$gRecaptchaResponse = $_POST['g-recaptcha-response'];
$remoteIp = $_SERVER['REMOTE_ADDR'];
$resp = $recaptcha->verify($gRecaptchaResponse, $remoteIp);

if ($resp->isSuccess()) {
    try {
        $mail = new PHPMailer(true); 

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rockandbeer65@gmail.com';
        $mail->Password = 'aymh goss reiu mlho';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
    
        $mail->setFrom($email, $nom);
        $mail->addAddress('rockandbeer65@gmail.com', 'Alexandre Hernandez');
    
        $mail->isHTML(true);
        $mail->Subject = 'Nouveau message du formulaire';
        $mail->Body    = "Message de :$prenom $nom  <br> Email : $email <br> Message : $message";
        $mail->AltBody = "Message de : $nom $prenom. Email : $email Message : $message";
    
        $mail->send();
        echo 'Le message a bien été envoyé';
    } catch (Exception $e) {
        echo "Le message n'a pas pu être envoyé. Erreur de Mailer : {$mail->ErrorInfo}";
    }} else {
    $errors = $resp->getErrorCodes();
    echo "Erreur lors de la vérification reCAPTCHA: " . implode(', ', $errors);
}
