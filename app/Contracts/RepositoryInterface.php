<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Closure;

interface RepositoryInterface
{
    /**
     * Get all data
     *
     * @return mixed
     */
    public function all();

    /**
     * Get one data
     *
     * @param integer|array $id ID
     *
     * @return mixed
     */
    public function find($id);

    /**
     * Save data
     *
     * @param array $data Recode
     *
     * @return mixed
     */
    public function store(array $data);

    /**
     * Create data
     *
     * @param array $attributes Attributes
     *
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * insert data and return the boolean.
     *
     * @param array $attributes
     * @return bool
     */
    public function insert(array $attributes): bool;

    /**
     * Update data
     *
     * @param integer $id ID
     * @param array $attributes Attributes
     *
     * @return mixed
     */
    public function update($id, array $attributes);

    /**
     * Get count
     *
     * @return mixed
     */
    public function count();

    /**
     * Create multiple
     *
     * @param array $data Recode data
     *
     * @return mixed
     */
    public function createMultiple(array $data);

    /**
     * Delete by id
     *
     * @param integer $id Identity of table
     *
     * @return mixed
     */
    public function deleteById($id);

    /**
     * Delete the specified model record from the database.
     *
     * @param array $data
     * @return bool|null
     */
    public function deleteByData(array $data): ?bool;

    /**
     * Hard delete the specified model record from the database.
     *
     * @param integer $id ID
     *
     * @return bool|null
     * @throws \Exception
     */
    public function hardDeleteById($id);

    /**
     * Delete multiple by id
     *
     * @param array $ids Id
     *
     * @return mixed
     */
    public function deleteMultipleById(array $ids);

    /**
     * Get first column
     *
     * @param array $columns column name
     *
     * @return mixed
     */
    public function first(array $columns = ['*']);

    /**
     * Get all data
     *
     * @param array $columns column name
     *
     * @return mixed
     */
    public function get(array $columns = ['*']);

    /**
     * Get the first specified model record from the database.
     *
     * @param array $columns Column name
     *
     * @return Model|static
     */
    public function firstOrFail(array $columns = ['*']);

    /**
     * Get recode by id
     *
     * @param integer $id id
     * @param array $columns column
     *
     * @return mixed
     */
    public function getById($id, array $columns = ['*']);

    /**
     * Add a simple where clause to the query.
     *
     * @param string $column column
     * @param string $value value for column
     * @param string $operator operator
     *
     * @return mixed
     */
    public function where($column, $value, $operator = '=');

    /**
     * Add a simple where in clause to the query
     *
     * @param string $column
     * @param mixed  $values
     *
     * @return $this
     */
    public function whereIn($column, $values);

    /**
     * Set Eloquent relationships to eager load
     *
     * @param mixed $relations
     *
     * @return $this
     */
    public function with($relations);

    /**
     * Set an ORDER BY clause
     *
     * @param string $column
     * @param string $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc');

    /**
     * Set the query limit
     *
     * @param int $limit
     *
     * @return $this
     */
    public function limit($limit);

    /**
     * Get one or throw exception
     *
     * @param integer|array $id ID
     * @param mixed $columns
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException<\Illuminate\Database\Eloquent\Model>
     */
    public function findOrFail($id, $columns = ['*']);

    /**
     * Update batch data
     *
     * @param array $record
     * @param array $index
     * @return mixed
     */
    public function batchUpdate(array $record, array $index);

    /**
     * truncate data
     *
     * @return void
     */
    public function truncate();

        /**
     * Generates pagination of items in an array or collection.
     *
     * @param Collection|Collect $items Items
     * @param int $perPage Per page
     * @param int $page Number page
     *
     * @return LengthAwarePaginator
     */
    public function generatesPaginate($items, $perPage = 10, $page = null);

    /**
     * Delete the multiple resource.
     *
     * @param array $listId
     * @return bool
     */
    public function deleteMultiple(array $listId);

    /**
     * Execute select query
     *
     * @param string $query
     * @return array
     */
    public function executeSelectQuery(string $query);

    /**
     * Combines SQL and its bindings
     *
     * @param $query
     * @return string
     */
    public function getEloquentSqlWithBindings($query);

    /**
     * Set the columns to be selected.
     *
     * @param  array|mixed  $columns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function select(mixed $columns = ['*']);

    /**
     * Remove all or passed registered global scopes.
     *
     * @param  array|null  $scopes
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function withoutGlobalScopes(array $scopes = null);

    /**
     * Undocumented function
     *
     * @param string $relation
     * @param Closure|null $callback
     * @return Builder|\Illuminate\Database\Eloquent\Concerns\QueriesRelationships
     */
    public function whereDoesntHave(string $relation, Closure $callback = null);

    /**
     * Create or update a record matching the attributes, and fill it with values.
     *
     * @param  array  $attributes
     * @param  array  $values
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function updateOrCreate(array $attributes, array $values = []);

    /**
     * Get Laravel eloquent builder instance
     *
     * @return Builder
     */
    public function builder();
}
