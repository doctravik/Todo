<?php

namespace App\Models;

use Core\Database\Builder;
use App\Filters\TaskFilter;

class Task
{
    /**
     * @var string
     */
    protected $table = 'tasks';

    /**
     * Sort tasks.
     *
     * @param TaskFilter $filter
     * @return Builder
     */
    public static function sort(TaskFilter $filter)
    {
        $task = new static;

        return $filter->apply(
            (new Builder)->table($task->table)
        );
    }

    /**
     * Save task in the database.
     *
     * @param array $attributes
     * @return void
     */
    public static function create(array $attributes)
    {
        (new Builder)->table('tasks')->insert($attributes);
    }
}