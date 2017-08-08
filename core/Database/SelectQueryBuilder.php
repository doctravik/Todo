<?php

namespace Core\Database;

class SelectQueryBuilder
{
    /**
     * Prepare SELECT query.
     * 
     * @param  string $table
     * @param  string|array $columns
     * @return string
     */
    public static function prepare($table, $columns)
    {
        if( is_array($columns)) {
            $columns = implode(', ', $columns);
        }

        return "SELECT $columns FROM $table ";
    }
}