// Warten, bis die komplette Seite geladen ist
// Frage noch nicht abschließend geklärt wo und wann der DOM-CL benötigt wird.
document.addEventListener('DOMContentLoaded', () => {
    // Formular-Element und Bereich für Rückmeldungen auswählen
    const form = document.getElementById('contactForm');
    const formMessage = document.getElementById('formMessage');

    // Eventlistener auf das Abschicken des Formulars setzen
    form.addEventListener('submit', async (e) => {
        e.preventDefault(); // Verhindert das automatische Neuladen der Seite

        // Überprüfen, ob alle Formularfelder gültig sind
        if (!form.checkValidity()) {
            // Fehlermeldung anzeigen, wenn Felder nicht korrekt ausgefüllt sind
            formMessage.textContent = "Bitte füllen Sie alle Felder korrekt aus.";
            formMessage.style.color = "red";
            return; // Funktion beenden
        }

        // Meldung zurücksetzen, falls vorherige Nachricht angezeigt wurde
        formMessage.textContent = "";

        // Formulardaten sammeln
        const formData = new FormData(form);

        try {
            // Anfrage an den Server schicken (POST mit den Formulardaten)
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData
            });

            // Antworttext vom Server erhalten
            const text = await response.text();

            if (response.ok) {
                // Wenn Anfrage erfolgreich war:
                // Erfolgsmeldung in grün anzeigen
                formMessage.style.color = "blue";
                formMessage.textContent = text;
                // Formular zurücksetzen (leeren)
                form.reset();
            } else {
                // Bei Serverfehler Fehlermeldung anzeigen
                formMessage.style.color = "red";
                formMessage.textContent = text || "Fehler beim Senden der Nachricht.";
            }
        } catch (error) {
            // Bei Netzwerkproblemen Fehlermeldung anzeigen
            formMessage.style.color = "red";
            formMessage.textContent = "Netzwerkfehler. Bitte versuchen Sie es später erneut.";
        }
    });
});
