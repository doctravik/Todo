<?php

namespace Core\Database;

class InsertQueryBuilder
{
    /**
     * Prepare INSERT query.
     * 
     * @param  string $table
     * @param  array $data
     * @return string
     */
    public static function prepare($table, array $data)
    {
        return sprintf("INSERT INTO $table (%s) VALUES (%s) ",
            implode(', ', array_keys($data)),
            implode(',', array_fill(1, count($data), '?'))
        );
    }
}