<?php 

namespace Alura\Pdo\Infrastructure\Repository;

use PDO;
use DateTimeInterface;
use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentRepository;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use DateTimeImmutable;
use PDOStatement;

class PdoStudentRepository extends StudentRepository
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = ConnectionCreator::createConnection();
    }

    public function allStudents(): array
    {
        $query = 'SELECT * FROM students';
        $stmt = $this->connection->query($query);

        return $this->hydrateStudentList($stmt);
    }

    public function studentBirthAt(DateTimeInterface $birthDate): array 
    {
        $query = 'SELECT * FROM students WHERE birth_date = :birth_date;';
        $stmt = $this->connection->prepare($query);

        $stmt->bindValue(':birth_date', $birthDate->format('Y-m-d'));
        $stmt->execute();

        return $this->hydrateStudentList($stmt);
    }

    public function hydrateStudentList(PDOStatement $stmt): array
    {
        $studentDataList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $studentList = [];

        foreach ($studentDataList as $studentData) {
            
            $studentList[] = new Student(
                $studentData['id'],
                $studentData['name'],
                new DateTimeImmutable($studentData['birth_date'])
            ) ;
        }

        return $studentList;
    }

    public function save(Student $student): bool
    {
        if ($student->id() === null) {
            return $this->insert($student);
        }

        return $this->update($student);
    }

    private function insert(Student $student): bool
    {
        $query = 'INSERT INTO students (name, birth_date) VALUES (:name, :birth_date)';
        $stmt = $this->connection->prepare($query);

        $success = $stmt->execute([
            ':name' => $student->name(),
            ':birth_date' => $student->birthDate()->format('Y-m-d'),
        ]);

        if ($success) {
            $student->defineId($this->connection->lastInsertId());
        }        

        return $success;
    }

    private function update(Student $student): bool
    {
        $query = 'UPDATE students SET name = :name, birth_date = :birth_date WHERE id = :id';
        $stmt = $this->connection->prepare($query);

        $stmt->bindValue(':name', $student->name());
        $stmt->bindValue(':birth_date', $student->birthDate()->format('Y-m-d'));
        $stmt->bindValue(':id', $student->id(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function remove(Student $student): bool
    {
        $stmt = $this->connection->prepare('DELETE FROM students WHERE id = :id;');
        $stmt->bindValue(':id', $student->id(), PDO::PARAM_INT);

        return $stmt->execute();
    }
}