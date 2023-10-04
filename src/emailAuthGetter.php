<?php

$servername = "localhost";
$username = "trendwave";
$password = "ybnykF4ACMnSpU";
$databaseName = "TrendWave";

$conn = new mysqli($servername, $username, $password, $databaseName);

if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}


if($_SERVER["REQUEST_METHOD"] === "GET"){
    if(isset($_GET["uuid"]) && isset($_GET["code"])){
        // CREATION OF NEW CODE AND RETURN OF IT
        $uuid = $_GET["uuid"];
        $code = $_GET["code"];
        $result = getNewCode($conn, $code, $uuid);
        echo $result;
    }else if(isset($_GET["uuid"])){
        // RETURN CODE OF UUID
        $uuid = $_GET["uuid"];
        echo getCodeByUUID($conn, $uuid);
    }
}



function getNewCode($conn, $code, $uuid){
    $sql = "INSERT INTO emailauth (code, uuid, available) VALUES (\'$code\', \'$uuid\', true)";
    $result = $conn->query($sql); 
    return $result;
}

function getCodeByUUID($conn, $uuid){
    $sql = "SELECT FROM emailauth WHERE uuid = \'$uuid\' AND available = true";
    $result = $conn->query($sql);
    return $result;
}
?>