// Führt den Code erst aus, wenn das ganze HTML geladen ist
document.addEventListener('DOMContentLoaded', () => {

    // Funktion zur Berechnung des Body-Mass-Index (BMI)
    function berechneBMI() {
        // Eingabe für Gewicht (in kg) auslesen
        let gewicht = document.getElementById("gewicht").value;

        // Eingabe für Größe (in cm) auslesen
        let grosse = document.getElementById("grosse").value;

        // Berechnung des BMI (kg / m²)
        // Da Größe in cm eingegeben wird, wird mit 10.000 (100x100) multipliziert
        let bmi = gewicht / (grosse * grosse) * 10000;

        // Ausgabe des BMI-Werts
        document.getElementById("satzanfang").innerHTML = "Ihr BMI ist: ";
        document.getElementById("bmi").innerHTML = bmi.toFixed(1); // eine Nachkommastelle

        // Bewertung des BMI-Werts
        if (bmi <= 24.9) {
            document.getElementById("nachricht").innerHTML = "Sie haben Untergewicht.";
        } else if (bmi > 24.9 && bmi < 29.9) {
            document.getElementById("nachricht").innerHTML = "Sie haben Normalgewicht.";
        } else {
            document.getElementById("nachricht").innerHTML = "Sie haben Übergewicht.";
        }
    }

    // Funktion zum Zurücksetzen der Seite (lädt einfach neu)
    // Funktioniert wohl nicht (immer) überall
    function loscheEingabe() {
        window.location.reload();
    }

    // Macht die Funktionen global zugänglich für den HTML-Aufruf über onclick=""
    window.berechneBMI = berechneBMI;
    window.loscheEingabe = loscheEingabe;
});
