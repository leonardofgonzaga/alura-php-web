<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection(); 

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