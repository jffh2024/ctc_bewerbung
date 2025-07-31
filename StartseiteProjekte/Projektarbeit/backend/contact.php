<?

// PHPMailer Bibliothek einbinden, damit über web.de E-Mails gesendet werden können
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
require '../PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Nur bei POST-Anfragen 
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 1. Benutzereingaben sicher verarbeiten
    $name = strip_tags(trim($_POST["name"] ?? ''));           // Name ohne HTML-Tags und Leerzeichen
    $email = filter_var(trim($_POST["email"] ?? ''), FILTER_VALIDATE_EMAIL); // E-Mail validieren
    $message = trim($_POST["message"] ?? '');                 // Nachricht bereinigen

    // 2. Prüfen, ob alle Felder korrekt ausgefüllt sind
    if (empty($name) || !$email || empty($message)) {
        http_response_code(400); // Fehlermeldung, falls etwas fehlt
        echo "Bitte fuellen Sie alle Felder korrekt aus.";
        exit; // Skript stoppen
    }

    // 3. Neues PHPMailer-Objekt erstellen
    $mail = new PHPMailer(true);

    try {
        // 4. SMTP-Server web.de
        $mail->isSMTP();
        $mail->Host = 'smtp.web.de';                 // SMTP-Host
        $mail->SMTPAuth = true;                     // Authentifizierung aktivieren
        $mail->Username = 'helmut-laemmle@web.de';  // SMTP-Benutzername
        $mail->Password = 'NP4RIY46TT3KJ5ODP6LE';   // SMTP-Passwort (hier Beispiel)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Verschlüsselung
        $mail->Port = 587;                           // Port

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
