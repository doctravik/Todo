<?php

namespace Core\Pagination;

use Core\Container;

class CurrentPageResolver
{
    /**
     * Resolve current page.
     * 
     * @return int
     */
    public static function resolve()
    {
        return (new static)->getCurrentPage();
    }

    /**
     * @return int|null
     */
    protected function getCurrentPage()
    {
        $page = Container::instance()->request->input('page');

        return $this->isValidNumber($page) ? $page : null;
    }

    /**
     * Validate page value.
     * 
     * @param  int $page
     * @return boolean
     */
    protected function isValidNumber($page)
    {
        return $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false;
    }
}