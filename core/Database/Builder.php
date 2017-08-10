<?php

namespace Core\Database;

use Core\Container;
use Core\Pagination\Paginator;
use Core\Database\DeleteQueryBuilder;
use Core\Database\InsertQueryBuilder;
use Core\Database\SelectQueryBuilder;
use Core\Database\UpdateQueryBuilder;
use Core\Pagination\CurrentPageResolver;

class Builder
{
    /**
     * @var \PDO
     */
    protected $db;

    /**
     * @var string
     */
    protected $table = null;

    /**
     * @var array|string
     */
    protected $columns = '*';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var string
     */
    protected $query = '';

    /**
     * @var array
     */
    protected $criteria = [];

    /**
     * Allowed criterias.
     * 
     * @var array
     */
    protected $allowedCriterias = ['join', 'where', 'and', 'orderBy', 'limit', 'offset'];

    /**
     * Binding parameters for the main statement.
     * 
     * @var array
     */
    protected $bindings = [];

    /**
     * Binding parameters for the criteria statements.
     * 
     * @var array
     */
    protected $criteriaBindings = [];

    /**
     * Create new instance of the Builder.
     */
    public function __construct()
    {
        $this->db = Container::instance()->db;
    }

    /**
     * Set value for table property.
     * 
     * @param  string $table
     * @return $this
     */
    public function table($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Set value for columns property.
     * 
     * @param  string $table
     * @return $this
     */
    public function select(...$columns)
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * Build WHERE part of query.
     * 
     * @param  string $column
     * @param  string $operator
     * @param  string $value
     * @return $this
     */
    public function where($column, $operator, $value)
    {
        if (isset($this->criteria['where']) && count($this->criteria['where']) > 0) {
            $key = 'and';
        } else {
            $key = 'where';
        }

        $this->criteria[$key][] = "WHERE $column $operator ?";
        $this->criteriaBindings[$key][] = $value;

        return $this;
    }

    /**
     * Build ORDER BY part of query.
     * 
     * @param  string $column
     * @param  string $order
     * @return $this
     */
    public function orderBy($column, $order = 'asc')
    {
        $this->criteria['orderBy'][] = "ORDER BY $column $order";

        return $this;
    }


    /**
     * Set LIMIT part of query.
     * 
     * @param  int $value
     * @return $this
     */
    public function limit($value)
    {
        $this->criteria['limit'][] = "LIMIT ?";
        $this->criteriaBindings['limit'][] = $value;


        return $this;
    }

    /**
     * Set OFFSET part of query.
     * 
     * @param  int $value
     * @return $this
     */
    public function offset($value)
    {
        $this->criteria['offset'][] = "OFFSET ?";
        $this->criteriaBindings['offset'][] = $value;

        return $this;
    }

    /**
     * Alias for offset function.
     * 
     * @param  int $value
     * @return $this
     */
    public function skip($value)
    {
        return $this->offset($value);
    }

    /**
     * Build INNER JOIN query.
     * 
     * @param  string $table
     * @param  string $leftColumn
     * @param  string $operator
     * @param  string $rightColumn
     * @return $this
     */
    public function join($table, $leftColumn, $operator, $rightColumn)
    {
        $this->criteria['join'][] = "INNER JOIN {$table} ON $leftColumn $operator $rightColumn";

        return $this;
    }

    /**
     * Execute insert query.
     * 
     * @param  array $data
     * @return void
     */
    public function insert(array $data)
    {
        $this->query = InsertQueryBuilder::prepare($this->table, $data);        
        $this->bindings = array_values($data);

        $this->execute();
    }

    /**
     * Execute update query.
     * 
     * @param  array $data
     * @return void
     */
    public function update(array $data)
    {
        $this->query = UpdateQueryBuilder::prepare($this->table, $data);
        $this->bindings = array_values($data);

        $this->execute();
    }

    /**
     * Execute delete query.
     * 
     * @return void
     */
    public function delete()
    {
        $this->query = DeleteQueryBuilder::prepare($this->table);

        $this->execute();
    }

    /**
     * Execute select query.
     * 
     * @return array
     */
    public function get()
    {
        $this->query = SelectQueryBuilder::prepare($this->table, $this->columns);

        $response = $this->execute();

        return $response->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Execute count query.
     *
     * @param  string $column
     * @return array
     */
    public function count($column = '*')
    {
        $this->query = SelectQueryBuilder::prepare($this->table, "count($column)");

        $response = $this->execute();

        return $response->fetchColumn();
    }

    /**
     * Execute select query with pagination.
     *
     * @param  integer $perPage
     * @return array
     */
    public function paginate($perPage = 10)
    {
        $page = $this->getCurrentPage();

        $total = $this->getCountForPagination();
        
        $paginator = new Paginator($page, $perPage, $total);
        
        $data = $total ? $this->getDataForPagination($paginator->currentPage(), $perPage) : [];

        return $paginator->setData($data);
    }

    /**
     * Get current page from uri.
     * 
     * @return int|null
     */
    protected function getCurrentPage()
    {
        return CurrentPageResolver::resolve() ?: 1;
    }

    /**
     * Define total number of items before pagination.
     * 
     * @return int
     */
    protected function getCountForPagination()
    {
        $builder = clone $this;
        $builder->setAllowedCriterias(['where', 'and']);

        return $builder->count();
    }

    /**
     * Set new values for allowed criterias.
     * 
     * @param array $criterias
     * @return void
     */
    protected function setAllowedCriterias(array $criterias)
    {
        $this->allowedCriterias = $criterias;
    }

    /**
     * Get paginated data.
     *
     * @param  int $page
     * @param  int $perPage
     * @return array
     */
    protected function getDataForPagination($page, $perPage)
    {
        return $this->limit($perPage)->skip(($page - 1) * $perPage)->get();
    }

    /**
     * Execute prepared query.
     * 
     * @return mixed
     */
    protected function execute()
    {
        [$criterias, $criteriaBindings] = $this->prepareCriterias();

        $query = $this->query . $criterias;

        $bindings = array_merge($this->bindings, $criteriaBindings);
var_dump($query);
var_dump($bindings);
        try {
            $statement = $this->db->prepare($query);
            $statement->execute($bindings);

            return $statement;
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Combine criterias in one string by order.
     * Combine criteriaBindings in one array by order.
     * 
     * @return array
     */
    protected function prepareCriterias()
    {
        $query = '';
        $bindings = [];

        foreach ($this->allowedCriterias as $name) {
            if (isset($this->criteria[$name])) {
                $query .= ' ' . implode(' ', $this->criteria[$name]);
            }

            if (isset($this->criteriaBindings[$name])) {
                array_push($bindings, ...$this->criteriaBindings[$name]);
            }
        }

        return [$query, $bindings];
    }
}