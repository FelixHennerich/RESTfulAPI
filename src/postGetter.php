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
    // Überprüfe, ob ein ID-Parameter übergeben wurde
    if (isset($_GET["id"]) && !isset($_GET["delete"])) {
        $postId = $_GET["id"];
        $post = findPostById($conn, $postId);
        if ($post) {
            echo json_encode($post);
        } else {
            http_response_code(404); // Benutzer nicht gefunden
            echo json_encode(["error" => "Benutzer nicht gefunden"]);
        }
    } else if(isset($_GET["uuid"])) {
        $uuid = $_GET["uuid"];
        $posts = getUserPosts($conn, $uuid);
        echo json_encode($posts);
    } else if(isset($_GET["delete"]) && isset($_GET["id"])){
        $id = $_GET["id"];
        $result = deleteUserPost($conn, $id);
        echo $result;
    } else {
        $posts = getRandomPosts($conn);
        echo json_encode($posts);
    }
}else if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(isset($_GET["id"]) && isset($_GET["uuid"]) && isset($_GET["date"]) && isset($_GET["text"])){
        $id = $_GET["id"];
        $uuid = $_GET["uuid"];
        $date = $_GET["date"];
        $text = $_GET["text"];
        $result = createPost($conn, $id, $uuid, $date, $text);
        echo $result; 
    }
}

/**
 * Upload post
 */

 function createPost($conn, $id, $uuid, $date, $text){
    $sql = "INSERT INTO posts(id, uuid, date, text) VALUES ('$id', '$uuid', '$date', '$text')";
    $result = $conn->query($sql);
    return $result;
 }


/**
 * Find post
 */

 function findPostById($conn, $id) {
    $sql = "SELECT * FROM posts WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

/**
 * Find Random Posts
 */

 function getRandomPosts($conn) {
    $sql = "SELECT * FROM posts
    ORDER BY RAND()
    LIMIT 10";
    $result = $conn->query($sql);

    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    return $users;
}


/**
 * Find User posts
 */

 function getUserPosts($conn, $uuid) {
    $sql = "SELECT * FROM posts WHERE uuid = '$uuid'";
    $result = $conn->query($sql);

    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    return $users;
}


/**
 * Delete Post
 */
 function deleteUserPost($conn, $id) {
    $sql = "DELETE FROM posts WHERE id = '$id'";
    $result = $conn->query($sql);
    return $result;
 }
 
?>