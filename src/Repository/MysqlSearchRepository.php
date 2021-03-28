<?php
declare(strict_types=1);

namespace Youtube\Repository;

use PDO;
use Youtube\Model\Search;

final class MysqlSearchRepository
{
    private PDOSingleton $database;
    private const DATE_FORMAT = 'Y-m-d H:i:s';

    public function __construct(PDOSingleton $database)
    {
        $this->database = $database;
    }

    public function save(Search $search): void
    {
        $query = <<<'QUERY'
        INSERT INTO searches(user_id, search, created_at)
        VALUES(:user_id, :search, :created_at)
        QUERY;

        $statement = $this->database->connection()->prepare($query);

        $user_id = $search->getUserId();
        $search_title = $search->getSearch();
        $created_at =$search->getCreatedAt()->format(self::DATE_FORMAT);

        $statement->bindParam('user_id', $user_id, PDO::PARAM_STR);
        $statement->bindParam('search', $search_title, PDO::PARAM_STR);
        $statement->bindParam('created_at', $created_at, PDO::PARAM_STR);

        $statement->execute();
    }
}