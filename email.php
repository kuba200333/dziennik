<?php

header('Content-type: text/html; charset=utf-8');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$imie = "Kuba";
$email = "kuba.wiercinski2003@gmail.com";
$tresc = "To prawda";
$temat = "Ja ci mówię"; 

date_default_timezone_set('Europe/Warsaw');

$mail = new PHPMailer(true);

 $mail->isSMTP(); // Używamy SMTP
 $mail->Host = 'smtp.gmail.com'; // Adres serwera SMTP
 $mail->SMTPAuth = true; // Autoryzacja (do) SMTP
 $mail->Username = "strzebonskipatryk666@gmail.com"; // Nazwa użytkownika
 $mail->Password = "lvaloqfqhndwdtpi"; // Hasło
 $mail->SMTPSecure = 'ssl'; // Typ szyfrowania (TLS/SSL)
 $mail->Port = 465; // Port

 $mail->CharSet = "UTF-8";
 $mail->setLanguage('pl', '/phpmailer/language');

 $mail->setFrom('strzebonskipatryk666@gmail.com', 'Patryk Strzeboński');
 $mail->addAddress($email);
 $mail->addReplyTo($email, $imie);

 $mail->isHTML(true); // Format: HTML
 $mail->Subject = $temat;
 $mail->Body = $tresc;
 $mail->AltBody = 'By wyświetlić wiadomość należy skorzystać z czytnika obsługującego wiadomości w formie HTML';

 $mail->send();


?>