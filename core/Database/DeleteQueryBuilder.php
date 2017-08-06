<?php

namespace Core\Database;

class DeleteQueryBuilder
{
    /**
     * Prepare DELETE query.
     * 
     * @param  string $table
     * @return string
     */
    public static function prepare($table)
    {
        return "DELETE FROM $table";
    }
}