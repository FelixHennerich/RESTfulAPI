<?php

/**
 * MySQL Connection
 */
header("Content-Type: application/json");

$servername = "localhost";
$username = "trendwave";
$password = "ybnykF4ACMnSpU";
$databaseName = "TrendWave";

$conn = new mysqli($servername, $username, $password, $databaseName);

if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}


/**
 * HTTP GET Requests
 */

 if ($_SERVER["REQUEST_METHOD"] === "GET") {
    
}else if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(isset($_GET["uuid"]) && isset($_GET["follower"]) && isset($_GET["add"])){
        $uuid = $_GET["uuid"];
        $follower = $_GET["follower"];
        $result = editFollow($conn, $uuid, $follower);
        echo $result;
    }else if(isset($_GET["uuid"]) && isset($_GET["following"]) && isset($_GET["add"]) && isset($_GET["followed"])){
        $uuid = $_GET["uuid"];
        $follower = $_GET["following"];
        $followed = $_GET["followed"];
        $result = editFollowing($conn, $uuid, $follower, $followed);
        echo $result;
    }else if(isset($_GET['uuid']) && isset($_GET['followed']) && isset($_GET['remove']) && !isset($_GET['following'])){
        $uuid = $_GET["uuid"];
        $follower = $_GET["followed"];
    }else if(isset($_GET["uuid"]) && isset($_GET["follower"]) && isset($_GET["remove"])){
        $uuid = $_GET["uuid"];
        $followed = $_GET["follower"];
        $result = editFollow($conn, $uuid, $followed);
        echo $result;
    }else if(isset($_GET["uuid"]) && isset($_GET["following"]) && isset($_GET["remove"]) && isset($_GET["followed"])){
        $uuid = $_GET["uuid"];
        $follower = $_GET["following"];
        $followed = $_GET["followed"];
        $result = editFollowing($conn, $uuid, $follower, $followed);
        echo $result;
    }
}

/**
 * Add follow
 */
 function editFollow($conn, $uuid, $follower){
    $sql = "UPDATE newsuser SET follower = $follower WHERE uuid = '$uuid'";
    $result = $conn->query($sql);
    return $result; 
 }


 /**
 * Add following to database
 */
function editFollowing($conn, $uuid, $follower, $followed){
    $sql = "UPDATE newsuser SET following = $follower WHERE uuid = '$uuid'";
    $result = $conn->query($sql);

    $sql1 = "UPDATE newsuser SET followed = '$followed' WHERE uuid = '$uuid'";
    $result1 = $conn->query($sql1);
    return $result + $result1; 
 }
 
 
?>