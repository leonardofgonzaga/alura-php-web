<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$databasePath = __DIR__ . "/banco.sqlite";
$pdo = new PDO('sqlite:' . $databasePath);

$stmt = $pdo->query('SELECT * FROM students');

// var_dump($stmt->fetchColumn(1)); exit;

$studentDataList = $stmt->fetchAll(PDO::FETCH_ASSOC);
// var_dump($stmt->fetchAll(PDO::FETCH_CLASS, Student::class));

$studenList = [];
foreach ($studentDataList as $studentData) {
 
    $studenList[] = new Student(
        $studentData['id'],
        $studentData['name'],
        new DateTimeImmutable($studentData['birth_date'])
    );
}

var_dump($studenList);