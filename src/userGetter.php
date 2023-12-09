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
    if (isset($_GET["uuid"]) && !isset($_GET["delete"])) {
        $uuid = $_GET["uuid"];
        $user = findUserById($conn, $uuid);
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Benutzer nicht gefunden"]);
        }
    } else if (isset($_GET["email"]) && !isset($_GET["delete"])) {
        $email = $_GET["email"];
        $user = findUserByEmail($conn, $email);
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Benutzer nicht gefunden"]);
        }
    } else if (isset($_GET["username"]) && !isset($_GET["delete"])) {
        $username = $_GET["username"];
        $user = findUserByUsername($conn, $username);
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Benutzer nicht gefunden"]);
        }
    } else if(isset($_GET["uuid"]) && isset($_GET["delete"])){
        $uuid = $_GET["uuid"];
        $result = deleteUser($conn, $uuid);
        echo $result;
    }
}else if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(isset($_GET["uuid"]) && isset($_GET["birthday"]) && !isset($_GET["value"])){
        echo "hallo";
        $uuid = $_GET['uuid'];
        $email = $_GET['email'];
        $username = $_GET['username'];
        $password = $_GET['password'];
        $signup = $_GET['signup'];
        $birthday = $_GET['birthday'];
        $role = $_GET['role'];
        echo $uuid.$email.$username.$password.$signup.$birthday.$role;
        $result = createUser($conn, $uuid, $email, $username, $password, $signup, $birthday, $role);
        echo $result;
    }else if(isset($_GET["username"])){
        $username = $_GET["username"];
        $result = checkUserName($conn, $username);
        if($result == null){
            echo "Username is free";
        }else {
            echo "Username is used";
        }
    }else if(isset($_GET["email"])){
        $email = $_GET["email"];
        $result = checkEmail($conn, $email);
        if($result == null){
            echo "Email is free";
        }else {
            echo "Email is used";
        }
    }
}

/**
 * Username exists?
 */

 function checkUserName($conn, $username){
    $sql = "SELECT * FROM newsuser WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows >= 1) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
 }


/**
 * Email exists?
 */

 function checkEmail($conn, $email){
    $sql = "SELECT * FROM newsuser WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows >= 1) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
 }

/**
 * Upload user
 */

 function createUser($conn, $uuid, $email, $username, $password, $signup, $birthday, $role){
    $sql = "INSERT INTO newsuser (uuid, email, password, username, birthday, signup, role, follower, following, followed, homebuttons) VALUES ('$uuid','$email','$password','$username','$birthday','$signup','$role',0,0,'','')";
    $result = $conn->query($sql);
    return $result;
 }


/**
 * Find user
 */

 function findUserById($conn, $uuid) {
    $sql = "SELECT * FROM newsuser WHERE uuid = '$uuid'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

/**
 * Find user
 */

 function findUserByEmail($conn, $email) {
    $sql = "SELECT * FROM newsuser WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

/**
 * Find user
 */

 function findUserByUsername($conn, $username) {
    $sql = "SELECT * FROM newsuser WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}


/**
 * Delete user
 */
 function deleteUser($conn, $uuid) {
    $sql = "DELETE FROM newsuser WHERE uuid = '$uuid'";
    $result = $conn->query($sql);
    return $result;
 }
 
?>