<?php



function save Entry($data) {
    $db = new mysqli('localhost', 'root', '', 'zahnarzt'); //Hier melde ich mich als Nutzer der DB an
    
    if ($db->connect_error) {
      die("Connection failed: " . $db->connect_error);  //Hier prüfe ich. ob die Verbindung mit der DB erfolgreich war
    }
    
    $cols = [];        //in diesem Array werde ich Spaltennamen der Tabelle speichern
    $values = [];     // in diesem Array werde  ich die einzutragenden werte speichern 
    foreach($data as $key => $value) {         //Schleifendurchgang durch die daten 
        $cols[] = $key;                        // Die Schlüsselwörter (Spaltennamen) werden in den cols Array geschrieben 
        $values[] = $value;                    // Die werte werden in den values array geschrieben 
    }

    $result = $db->query("INSERT INTO form_submissions (" . implode(',', $cols) . ") VALUES ('". implode("','", $values) ."')"); // implode spaltet einen String mit einem Delimeter auf (in diesem Fall ein Komma). das ist deswegen notwenidig, da die SQL Abfrage mit durch , getrennte Werte verarbeitet wird  
    echo $result; Ausgabe result M
}


?>
