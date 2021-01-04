<?php
    $dsn = "mysql:host=localhost;dbname=discussion";
    $userDB = 'root';
    $passDB = '';
    $pdo = new PDO("$dsn","$userDB", "$passDB");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
