<?php

namespace Core\Database;

use PDO;
use PDOException;

class Connection
{
    /**
     * @var array
     */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Make connection to the database.
     * 
     * @return PDO
     */
    public function make()
    {
        try {
            return new PDO($this->getDsn(), 
                $this->config['user'], 
                $this->config['password'],
                $this->config['options']
            );
        } catch (PDOException $e) {
            die('Could not connect to database');
        }
    }

    /**
     * Configure dsn string for PDO connection.
     * 
     * @return string
     */
    private function getDsn()
    {
        return sprintf("%s:host=%s;dbname=%s",
            $this->config['connection'],
            $this->config['host'],
            $this->config['dbname']
        );
    }
}