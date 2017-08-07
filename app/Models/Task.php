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
}