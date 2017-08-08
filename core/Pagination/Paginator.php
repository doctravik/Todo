<?php

namespace Core\Pagination;

use ArrayIterator;
use Core\Container;
use IteratorAggregate;

class Paginator implements IteratorAggregate
{
    /**
     * Current page.
     * 
     * @var int
     */
    protected $currentPage;

    /**
     * Number of displayed items per page.
     * 
     * @var int
     */
    protected $perPage;

    /**
     * Total number of items.
     * 
     * @var int
     */
    protected $total;

    /**
     * Last page of the paginator.
     * 
     * @var int
     */
    protected $lastPage;

    /**
     * Paginated data from db.
     * 
     * @var array
     */
    protected $data;

    /**
     * Page name displayed in the url.
     * 
     * @var string
     */
    protected $pageName = 'page';

    /**
     * @var array
     */
    protected $urlQueries;

    /**
     * Create an instance of Paginator
     *
     * @param int $currentPage
     * @param int $perPage
     * @param int $total
     * @param array $data
     */
    public function __construct($currentPage, $perPage, $total, array $data)
    {
        $this->perPage = $perPage;
        $this->total = $total;
        $this->lastPage = (int) ceil($total / $perPage);
        $this->currentPage = $this->normalizeCurrentPage($currentPage);
        $this->data = $data;

        $this->urlQueries = Container::instance()->request->all();
    }

    /**
     * Ensure that current page has a valid value.
     * 
     * @return void
     */
    public function normalizeCurrentPage($currentPage)
    {
        if ($currentPage > $this->lastPage) {
            return $this->lastPage;
        }

        if ($currentPage < 1) {
            return 1;
        }

        return $currentPage;
    }

    /**
     * Getter for current page.
     *
     * @return int
     */
    public function currentPage()
    {
        return $this->currentPage;
    }

    /**
     * Getter for last page.
     *
     * @return int
     */
    public function lastPage()
    {
        return $this->lastPage();
    }

    /**
     * Check if paginator has pages.
     * 
     * @return boolean
     */
    public function hasPages()
    {
        return $this->lastPage > 0;
    }

    /**
     * Define url of the next page.
     * 
     * @return string|null
     */
    public function nextPageUrl()
    {
        if ($this->hasNextPage()) {
            return $this->createUrlFor($this->currentPage + 1);        
        }

        return null;
    }

    /**
     * Check if paginator has next page.
     * 
     * @return boolean
     */
    public function hasNextPage()
    {
        return $this->currentPage < $this->lastPage;
    }

    /**
     * Define url of the previous page.
     * 
     * @return string|null
     */
    public function previousPageUrl()
    {
        if ($this->hasPreviousPage()) {
            return $this->createUrlFor($this->currentPage - 1);        
        }

        return null;
    }

    /**
     * Check if paginator has previous page.
     * 
     * @return boolean
     */
    public function hasPreviousPage()
    {
        return $this->currentPage > 1;
    }

    /**
     * Get pages.
     * 
     * @return array
     */
    public function pages()
    {
        $range = range(1, $this->lastPage);

        return array_reduce($range, function ($carry, $page) {
            $carry[$page] = $this->createUrlFor($page);
            return $carry;
        }, []);
    }

    /**
     * Create url for the page.
     * 
     * @param  int $page
     * @return string
     */
    protected function createUrlFor($page)
    {
        if ($page <= 0) {
            $page = 1;
        }

        $parameters = array_merge($this->urlQueries, [$this->pageName => $page]);        

        return '?' . http_build_query($parameters, '', '&');
    }

    /**
     * Render links for pagination.
     * 
     * @return string
     */
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }
}