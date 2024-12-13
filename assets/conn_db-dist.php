<?php
// Configuration de la base de données
$servername = "";
$username = "";
$password = "";
$dbname = "";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>