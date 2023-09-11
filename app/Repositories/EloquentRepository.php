<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as Collect;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\RepositoryInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Exception;
use Closure;

abstract class EloquentRepository implements RepositoryInterface
{
    /**
     * The repository model.
     *
     * @var Model
     */
    protected $model;

    /**
     * The query builder.
     *
     * @var Builder
     */
    protected $query;

    /**
     * Alias for the query limit.
     *
     * @var int
     */
    protected $take;

    /**
     * Array of related models to eager load.
     *
     * @var array
     */
    private $with = [];

    /**
     * Array of one or more where clause parameters.
     *
     * @var array
     */
    private $wheres = [];

    /**
     * Array of one or more where in clause parameters.
     *
     * @var array
     */
    private $whereIns = [];

    /**
     * Array of one or more ORDER BY column/value pairs.
     *
     * @var array
     */
    private $orderBys = [];

    /**
     * Array of scope methods to call on the model.
     *
     * @var array
     */
    private $scopes = [];

    /**
     * Handle dynamic method calls into the repository.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call(string $method, array $parameters)
    {
        return $this->model->{$method}(...$parameters);
    }

    /**
     * BaseEloquentRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get All
     * @return Collection|static[]
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Get instance
     *
     * @param integer|array $id ID
     * @param array|mixed $columns columns
     *
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        $this->newQuery()->eagerLoad();
        $foundModel = $this->query->find($id, $columns);
        $this->unsetWith();

        return $foundModel;
    }

    /**
     * Create a new model record in the database.
     * f
     * @param array $data Data
     *
     * @return Model
     */
    public function store(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Create
     *
     * @param array $attributes Attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * insert data and return the boolean.
     *
     * @param  array  $attributes
     * @return bool
     */
    public function insert(array $attributes): bool
    {
        return $this->model->insert($attributes);
    }

    /**
     * Update
     *
     * @param integer $id         ID
     * @param array   $attributes Attributes
     *
     * @return bool|mixed
     */
    public function update($id, array $attributes)
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }
        return false;
    }

    /**
     * Count the number of specified model records in the database.
     *
     * @return int
     */
    public function count(): int
    {
        return $this->get()->count();
    }

    /**
     * Create one or more new model records in the database.
     *
     * @param array $data Data
     *
     * @return Collection
     */
    public function createMultiple(array $data)
    {
        $models = new Collection();

        foreach ($data as $item) {
            $models->push($this->store($item));
        }

        return $models;
    }

    /**
     * Delete the specified model record from the database.
     *
     * @param integer $id ID
     *
     * @return bool|null
     * @throws \Exception
     */
    public function deleteById($id): bool
    {
        return $this->getById($id)->delete();
    }

    /**
     * Delete the specified model record from the database.
     *
     * @param array $data
     * @return bool|null
     */
    public function deleteByData(array $data): ?bool
    {
        if (empty($data)) {
            return false;
        }

        $queryBuilder = $this::query();
        foreach ($data as $column => $value) {
            $queryBuilder->where($column, $value);
        }

        return $queryBuilder->delete();
    }

    /**
     * Hard delete the specified model record from the database.
     *
     * @param integer $id ID
     *
     * @return bool|null
     * @throws \Exception
     */
    public function hardDeleteById($id): bool
    {
        return $this->getById($id)->forceDelete();
    }

    /**
     * Delete multiple records.
     *
     * @param array $ids Ids
     *
     * @return int
     */
    public function deleteMultipleById(array $ids): int
    {
        return $this->model->destroy($ids);
    }

    /**
     * Delete one or more model records from the database
     *
     * @return mixed
     */
    public function delete()
    {
        $this->newQuery()->setClauses()->setScopes();

        $result = $this->query->delete();

        $this->unsetClauses();

        return $result;
    }

    /**
     * Get the first specified model record from the database.
     *
     * @param array $columns Column name
     *
     * @return Model|static
     */
    public function first(array $columns = ['*'])
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $foundModel = $this->query->first($columns);

        $this->unsetClauses();
        $this->unsetWith();

        return $foundModel;
    }

    /**
     * Get all the specified model records in the database.
     *
     * @param array $columns Column name
     *
     * @return Collection|static[]
     */
    public function get(array $columns = ['*'])
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $models = $this->query->get($columns);

        $this->unsetWith();
        $this->unsetClauses();

        return $models;
    }

    /**
     * Get the first specified model record from the database.
     *
     * @param array $columns Column name
     *
     * @return Model|static
     */
    public function firstOrFail(array $columns = ['*'])
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $foundModel = $this->query->firstOrFail($columns);

        $this->unsetClauses();
        $this->unsetWith();

        return $foundModel;
    }

    /**
     * Get the specified model record from the database.
     *
     * @param integer $id      Id
     * @param array   $columns Column name
     *
     * @return Collection|Model
     */
    public function getById($id, array $columns = ['*'])
    {
        $this->unsetClauses();

        $this->newQuery()->eagerLoad();

        $foundModel = $this->query->findOrFail($id, $columns);

        $this->unsetWith();

        return $foundModel;
    }

    /**
     * Create a new instance of the model's query builder.
     *
     * @return $this
     */
    protected function newQuery()
    {
        $this->query = $this->model->newQuery();

        return $this;
    }

    /**
     * Add relationships to the query builder to eager load.
     *
     * @return $this
     */
    protected function eagerLoad()
    {
        foreach ($this->with as $relation) {
            $this->query->with($relation);
        }

        return $this;
    }

    /**
     * Set clauses on the query builder.
     *
     * @return $this
     */
    protected function setClauses()
    {
        foreach ($this->wheres as $where) {
            $this->query->where(
                $where['column'],
                $where['operator'],
                $where['value']
            );
        }

        foreach ($this->whereIns as $whereIn) {
            $this->query->whereIn($whereIn['column'], $whereIn['values']);
        }

        foreach ($this->orderBys as $orders) {
            $this->query->orderBy($orders['column'], $orders['direction']);
        }

        if (isset($this->take) && !is_null($this->take)) {
            $this->query->take($this->take);
        }

        return $this;
    }

    /**
     * Set clauses scopes on the query builder.
     *
     * @param string $method
     * @param mixed $args
     *
     * @return $this
     */
    protected function scopes($method, ...$args)
    {
        $this->scopes[] = compact('method', 'args');

        return $this;
    }

    /**
     * Set query scopes.
     *
     * @return $this
     */
    protected function setScopes()
    {
        foreach ($this->scopes as $scope) {
            if ($scope['args'] === []) {
                $this->query->{$scope['method']}();
                continue;
            }

            $args = '';
            foreach ($scope['args'] as $arg) {
                if (is_array($arg)) {
                    $args .= '[' . implode(', ', $arg) . '] ';
                    continue;
                }
                $args .= $arg . ' ';
            }
            $this->query->{$scope['method']}(trim($args));
        }

        return $this;
    }

    /**
     * Add a simple where clause to the query.
     *
     * @param string $column   column
     * @param string $value    value for column
     * @param string $operator operator
     *
     * @return $this
     */
    public function where($column, $value, $operator = '=')
    {
        $this->wheres[] = compact('column', 'value', 'operator');

        return $this;
    }

    /**
     * Add a simple where in clause to the query
     *
     * @param string $column
     * @param mixed  $values
     *
     * @return $this
     */
    public function whereIn($column, $values)
    {
        $values = is_array($values) ? $values : [$values];

        $this->whereIns[] = compact('column', 'values');

        return $this;
    }

    /**
     * Set Eloquent relationships to eager load
     *
     * @param mixed $relations
     *
     * @return $this
     */
    public function with($relations)
    {
        if (is_string($relations)) {
            $relations = explode(',', $relations);
        }

        $this->with = $relations;

        return $this;
    }

    /**
     * Set an ORDER BY clause
     *
     * @param string $column
     * @param string $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->orderBys[] = compact('column', 'direction');

        return $this;
    }

    /**
     * Set the query limit
     *
     * @param int $limit
     *
     * @return $this
     */
    public function limit($limit)
    {
        $this->take = $limit;

        return $this;
    }


    /**
     * Reset the query clause parameter arrays.
     * @return $this
     */
    protected function unsetClauses()
    {
        $this->wheres = [];
        $this->whereIns = [];
        $this->scopes = [];
        $this->take = null;
        $this->unsetOrderBy();

        return $this;
    }

    /**
     * Reset the query with arrays.
     *
     * @return $this
     */
    protected function unsetWith()
    {
        if (!empty($this->with)) {
            $this->with = [];
        }

        return $this;
    }

    /**
     * Reset the query order by arrays.
     * @return $this
     */
    protected function unsetOrderBy()
    {
        if (!empty($this->orderBys)) {
            $this->orderBys = [];
        }

        return $this;
    }

    /**
     * Get one or throw exception
     *
     * @param integer|array $id ID
     * @param mixed $columns
     *
     * @return mixed
     */
    public function findOrFail($id, $columns = ['*'])
    {
        $this->newQuery()->eagerLoad();
        $foundModel = $this->query->findOrFail($id, $columns);
        $this->unsetWith();

        return $foundModel;
    }

    /**
     * Update batch data
     *
     * @param array $record
     * @param array $index
     * @return bool|void
     */
    public function batchUpdate(array $record, array $index)
    {
        foreach (array_chunk($record, 1000) as $recordData) {
            $newValues = '';
            $whereConditions = '';
            $statements = [];

            if (!is_array($recordData)) {
                return false;
            }

            foreach ($recordData as $record) {
                $conditions = '';

                foreach ($record as $column => $value) {
                    // Build when condition
                    if (in_array($column, $index)) {
                        $conditions .= "\"$column\" = '$value' AND ";
                        continue;
                    }

                    // Build statement
                    $statements[$column][] = 'WHEN ' . rtrim($conditions, ' AND ')
                        . ' THEN ' . (is_null($value) ? 'null' : "'" . mysql_escape($value) . "'");
                }

                // Build where condition
                $whereConditions .= '(' . rtrim($conditions, ' AND ') . ') OR ';
            }

            foreach ($statements as $column => $value) {
                $newValues .= '"' . $column . '" = (CASE ' . implode(' ', $value)
                    . ' ELSE ' . $column . ' END), ';
            }

            DB::statement('UPDATE "' . $this->model->getTable() . '" SET '
                . rtrim($newValues, ', ')
                . ' WHERE ' . rtrim($whereConditions, ' OR ') . ';');

            return true;
        }
    }

    /**
     * Truncate data
     *
     * @return void
     */
    public function truncate()
    {
        return $this->model::query()->truncate();
    }

    /**
     * Generates pagination of items in an array or collection.
     *
     * @param Collection|Collect $items Items
     * @param int $perPage Per page
     * @param int $page Number page
     *
     * @return LengthAwarePaginator
     */
    public function generatesPaginate($items, $perPage = 10, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collect::make($items);

        return new LengthAwarePaginator(
            $items->forPage($page, $perPage)->values(),
            $items->count(),
            $perPage,
            $page,
            [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]
        );
    }

    /**
     * Delete the multiple resource.
     *
     * @param array $listId
     * @return bool
     */
    public function deleteMultiple(array $listId)
    {
        DB::beginTransaction();
        try {
            $count = $this->model->destroy($listId);
            DB::commit();
            if ($count != 0) {
                return true;
            }
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return false;
        }
    }

    /**
     * Execute select query
     *
     * @param string $query
     * @return array
     */
    public function executeSelectQuery(string $query)
    {
        return DB::select($query);
    }

    /**
     * Combines SQL and its bindings
     *
     * @param $query
     * @return string
     */
    public function getEloquentSqlWithBindings($query)
    {
        return vsprintf(
            str_replace('?', '%s', $query->toSql()),
            collect($query->getBindings())->map(function ($binding) {
                return !is_string($binding) ? $binding : "'{$binding}'";
            })->toArray()
        );
    }

    public function select(mixed $columns = ['*'])
    {
        return $this->model->select($columns);
    }

    public function withoutGlobalScopes(array $scopes = null)
    {
        return $this->model->withoutGlobalScopes($scopes);
    }

    public function whereDoesntHave(string $relation, Closure $callback = null)
    {
        return $this->model->whereDoesntHave($relation, $callback);
    }

    public function updateOrCreate(array $attributes, array $values = [])
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    public function builder()
    {
        return $this->model->query();
    }
}
