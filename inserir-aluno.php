<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$databasePath = __DIR__ . "/banco.sqlite";
$pdo = new PDO('sqlite:' . $databasePath);

$student = new Student(
    null, 
    "Leonardo', ''); DROP TABLE students; -- Gonzaga", 
    new DateTimeImmutable('1995-03-03')
);

$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (:name, :birth_date)";
$stmt = $pdo->prepare($sqlInsert);
$stmt->bindValue("name", $student->name());
$stmt->bindValue("birth_date", $student->birthDate()->format("Y-m-d"));

if($stmt->execute()) {
    echo "Aluno incluído";
}