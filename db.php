<?php
// Paramètres de connexion
$host = 'localhost';
$dbname = 'gestion_adresses';
$username = 'steven';
$password = 'Bazouzgang';

// Connexion à MariaDB
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>