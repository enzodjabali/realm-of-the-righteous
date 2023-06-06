<?php
declare(strict_types = 1);

namespace App\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailSender
{
    /**
     * This method sends an email to a given recipient
     * @param string $recipientEmail the email the recipient
     * @param string $subject the subject of the email
     * @param string $body the html body of the email
     * @return string|bool returns true if the operation succeed, and returns a string containing an error message if it failed
     */
    static function sendEmail(string $recipientEmail, string $subject, string $body): string|bool {
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
            $mail->addAddress($recipientEmail);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return $mail->ErrorInfo;
        }
    }
}