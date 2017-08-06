<?php

namespace Core\Database;

use Core\Container;
use Core\Database\DeleteQueryBuilder;
use Core\Database\InsertQueryBuilder;
use Core\Database\SelectQueryBuilder;
use Core\Database\UpdateQueryBuilder;

class Builder
{
    /**
     * @var \PDO
     */
    private $db;

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
     * @var string
     */
    protected $criteria = '';

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
        $this->criteria .= " WHERE $column $operator ?";

        array_push($this->criteriaBindings, $value);

        return $this;
    }

    /**
     * Build ORDER BY part of query.
     * 
     * @param  string $column
     * @param  string $order
     * @return $this
     */
    public function orderBy($column, $order)
    {
        $this->criteria .= " ORDER BY $column $order";

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
     * @return array
     */
    public function count()
    {
        $this->query = SelectQueryBuilder::prepare($this->table, $this->columns);

        $response = $this->execute();

        return $response->fetchColumn();
    }

    /**
     * Execute prepared query.
     * 
     * @return mixed
     */
    protected function execute()
    {
        $query = $this->query . $this->criteria;
        $bindings = array_merge($this->bindings, $this->criteriaBindings);

        try {
            $statement = $this->db->prepare($query);
            $statement->execute($bindings);

            return $statement;
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }
}
