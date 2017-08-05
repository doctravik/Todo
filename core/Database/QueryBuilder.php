<?php

namespace Core\Database;

use PDO;

class QueryBuilder
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;        
    }
    
    /**
     * Select all rows from the table.
     * 
     * @param string $table
     * @return array
     */
    public function selectAll($table)
    {
        $statement = $this->pdo->prepare("select * from $table");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Insert attributes into the given table.
     * 
     * @param  string $table
     * @param  array  $attributes
     * @return boolean
     */
    public function insert($table, array $attributes)
    {
        $query = sprintf("INSERT INTO $table (%s) VALUES (%s)",
            implode(',', array_keys($attributes)),
            ':' . implode(', :', array_keys($attributes))
        );

        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute($attributes);
        } catch (\Exception $e) {
            die('Inserting has been failed');
        }
    }
}