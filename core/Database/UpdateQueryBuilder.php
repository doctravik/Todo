<?php

namespace Core\Database;

class UpdateQueryBuilder
{
    /**
     * Prepare UPDATE query.
     *
     * @param  string $table
     * @param  array $data
     * @return string
     */
    public static function prepare($table, array $data)
    {
        $bindings = array_map(function ($key) {
            return "$key = ?";
        }, array_keys($data));

        return sprintf(
            "UPDATE $table SET %s ",
            implode(', ', $bindings)
        );
    }
}
