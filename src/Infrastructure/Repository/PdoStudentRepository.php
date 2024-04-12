<?php 

namespace Alura\Pdo\Infrastructure\Repository;

use PDO;
use Alura\Pdo\Domain\Repository\StudentRepository;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;

class PdoStudentRepository extends StudentRepository
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = ConnectionCreator::createConnection();
    }

    public function allStudents(): array
    {

    }

    public function studentBirthAt(DateTimeInterface $birthDate): array 
    {

    }

    public function save(Student $student): bool
    {

    }

    public function remove(Student $student): bool
    {

    }
}