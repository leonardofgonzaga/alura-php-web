<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$databasePath = __DIR__ . "/banco.sqlite";
$pdo = new PDO('sqlite:' . $databasePath);

$student = new Student(
    null, 
    "Teste", 
    new DateTimeImmutable('1995-03-03')
);

$name = $student->name();

$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (:name, :birth_date)";
$stmt = $pdo->prepare($sqlInsert);
$stmt->bindParam("name", $name); // passa por referência
$stmt->bindValue("birth_date", $student->birthDate()->format("Y-m-d"));

if($stmt->execute()) {
    echo "Aluno incluído";
}