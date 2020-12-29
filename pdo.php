<?php
    $dsn = "mysql:host=localhost;dbname=livreor";
    $userDB = 'root';
    $passDB = '';
    // $pdo = new PDO("mysql:host=$host;port=8889;dbname=$dBase","$userDB", "$passDB");
    $pdo = new PDO("$dsn","$userDB", "$passDB");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>