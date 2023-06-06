<?php
declare(strict_types = 1);

namespace App\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailSender
{
    static function sendEmail(string $recipientEmail, string $recipientUsername): string {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = $_ENV['EMAIL_HOST'];                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = $_ENV['EMAIL_USERNAME'];                // SMTP username
            $mail->Password   = $_ENV['EMAIL_PASSWORD'];                // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable implicit TLS encryption
            $mail->Port       = $_ENV['EMAIL_PORT'];                    // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            // Sender
            $mail->setFrom($_ENV['EMAIL_USERNAME'], 'Realm Of The Righteous');

            //Recipient
            $mail->addAddress($recipientEmail, $recipientUsername);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return 'Message has been sent';
        }

        catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}