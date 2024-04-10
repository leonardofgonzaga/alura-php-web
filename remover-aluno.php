<?php

require_once 'vendor/autoload.php';

$databasePath = __DIR__ . "/banco.sqlite";
$pdo = new PDO('sqlite:' . $databasePath);

$sqlDelete = 'DELETE FROM students WHERE id = :id';
$stmt = $pdo->prepare($sqlDelete);
$stmt->bindValue(':id', '4', PDO::PARAM_INT);

var_dump($stmt->execute());