<?php

try {
    $dns = sprintf('mysql:host=%s;port=%d;dbname=%s', DB_HOST,DB_PORT, DB_NAME);
    $pdo = new pdo($dns,
        DB_USER,
        DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
} catch (Exception $e) {
    die('Impoosible de se connecter au serveur Mysql' . $e->getMessage());
}