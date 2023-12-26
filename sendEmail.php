<?php

if(isset($_GET["code"]) && isset($_GET["first"]) && isset($_GET["second"])){
    $code = $_GET["code"];
    $first = $_GET["first"];
    $second = $_GET["second"];

    emailSender($first, $second, $code);
}

function emailSender($first, $second, $code){
    $jarPath = "/home/trendwave/emailsender-0.0.1-SNAPSHOT.jar";
    $command = "java -jar $jarPath $first $second $code";
    exec($command, $output, $returnCode);
    echo $returnCode;
    // Optional: Überprüfe den Rückgabewert, um zu sehen, ob der Befehl erfolgreich war
    if ($returnCode !== 0) {
        echo "Fehler beim Ausführen des Befehls: $command";
    }
}
?>