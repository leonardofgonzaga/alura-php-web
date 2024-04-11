<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection(); 

$sqlDelete = 'DELETE FROM students WHERE id = :id';
$stmt = $pdo->prepare($sqlDelete);
$stmt->bindValue(':id', '4', PDO::PARAM_INT);

var_dump($stmt->execute());