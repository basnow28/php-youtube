<?php
declare(strict_types=1);

namespace Youtube\Repository;

use PDO;
use Youtube\Model\User;
use Youtube\Model\UserLogin;
use Youtube\Service\UserService;

final class MysqlUserRepository implements UserService
{
    private PDOSingleton $database;
    private const DATE_FORMAT = 'Y-m-d H:i:s';

    public function __construct(PDOSingleton $database)
    {
        $this->database = $database;
    }

    public function save(User $user): int
    {
        $query = <<<'QUERY'
        INSERT INTO users(email, password, created_at)
        VALUES(:email, :password, :created_at)
        QUERY;
        
        $statement = $this->database->connection()->prepare($query);

        $email = $user->getEmail();
        $password = $user->getPassword();
        $createdAt = $user->getCreatedAt()->format(self::DATE_FORMAT);

        $statement->bindParam('email', $email, PDO::PARAM_STR);
        $statement->bindParam('password', $password, PDO::PARAM_STR);
        $statement->bindParam('created_at', $createdAt, PDO::PARAM_STR);

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_OBJ);
        foreach($result as $r){
            echo $r;
        }

        return intval("16"); 
    }

    public function login(UserLogin $user): int
    {
        $query = <<<'QUERY'
        SELECT id, email FROM users WHERE email = :email AND password = :password
QUERY;
        $statement = $this->database->connection()->prepare($query);

        $email = $user->getEmail();
        $password = $user->getPassword();

        $statement->bindParam('email', $email, PDO::PARAM_STR);
        $statement->bindParam('password', $password, PDO::PARAM_STR);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);

        return intval($result[0]->id);
    }
}