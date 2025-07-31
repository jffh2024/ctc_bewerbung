<?php

//PHPMailer Bibliothek einbinden, damit über web.de E-Mails gesendet werden können
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
require '../PHPMailer/Exception.php';

require_once 'db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Nur bei POST-Anfragen 
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 1. Benutzereingaben sicher verarbeiten
    $vorname = strip_tags(trim($_POST["name"] ?? ''));  
    $nachname = strip_tags(trim($_POST["surname"] ?? ''));           // Name ohne HTML-Tags und Leerzeichen
    $email = filter_var(trim($_POST["email"] ?? ''), FILTER_VALIDATE_EMAIL); // E-Mail validieren
    // toDo $option 
    $message = trim($_POST["message"] ?? '');                 // Nachricht bereinigen
    $name = $vorname . ' ' . $nachname;

    // 2. Prüfen, ob alle Felder korrekt ausgefüllt sind
    var_dump($vorname, $nachname, $email, $message);
    if (empty($vorname) || empty($nachname) || !$email || empty($message)) {
        http_response_code(400); // Fehlermeldung, falls etwas fehlt
        echo "Bitte fuellen Sie alle Felder korrekt aus.";
        exit; // Skript stoppen
    }

    // 3. Neues PHPMailer-Objekt erstellen
    $mail = new PHPMailer(true);

    try {
        // Looking to send emails in production? Check out our Email API/SMTP product!
        // Looking to send emails in production? Check out our Email API/SMTP product!
        // Looking to send emails in production? Check out our Email API/SMTP product!
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '5c2f51c72e969a';
            $mail->Password = 'acebaa27698ad3';                  // Port

        // 5. Absender und Empfänger festlegen
        $mail->setFrom('helmut-laemmle@web.de', 'Kontaktformular');   // Nutzer Kontaktformular
        $mail->addAddress('helmut-laemmle@web.de');                   // Ich
        $mail->addReplyTo($email, $name);                             // Antwortadresse ist die Adresse des Users

        // 6. Inhalt der E-Mail an mich
        $mail->Subject = "Neue Kontaktanfrage von $name";
        $mail->Body = "Name: $name\nE-Mail: $email\n\n\n\nNachricht:\n$message";

        // 7. Erste Mail wird an mich gesendet
        $mail->send();

        // ---------------------------------------------------------
        //  Bestätigungsmail an den Absender senden
        // ---------------------------------------------------------

        // 8. Alle Empfänger löschen
        $mail->clearAllRecipients();

        // 9. Empfänger auf die E-Mail-Adresse des User setzen
        $mail->addAddress($email);

        // 10. Betreff und Inhalt für die Bestätigungsmail an den Nutzer
        $mail->Subject = "Bestaetigung Ihrer Nachricht";
        $mail->Body = "Guten Tag $name,\n\nVielen Dank fuer Ihre Nachricht! Ich habe sie erhalten und melde mich bald bei Ihnen.\n\n---\nIhre Nachricht:\n$message\n\nViele Gruesse\nHelmut Laemmle";

        // 11. Bestätigungsmail senden
        $mail->send();

        // 12. Erfolgsmeldung an das JScript geben ?  
        http_response_code(200);
        echo "Danke fuer Ihre Nachricht! Ich melde mich bald bei Ihnen. \n\n Viele Gruesse \n\nHelmut Laemmle";

        $entries = [
            'firstname' => $vorname,
            'lastname' => $nachname,
            'mail' => $email,
            'message' => $message
        ];
        saveEntry($entries);

    } catch (Exception $e) {
        // 13. Falls ein Fehler beim Senden auftritt, Fehlermeldung zurückgeben
        http_response_code(500);
        echo "Fehler beim Senden: " . $mail->ErrorInfo;
    }

} else {
    // 14. Wenn nicht per POST gesendet, Fehler zurückgeben
    http_response_code(405);
    echo "Wurde nicht per POST gesendet.";
}

?>
