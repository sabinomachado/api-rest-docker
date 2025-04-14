<?php

namespace App\Repositories\Crud;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CrudRepository
{
    /**
     * Get all the models.
     *
     * @return Collection
     */
    public function all();

    /**
     * Obtains a list with the given fields
     *
     * @param  array $select
     * @param  array $with
     * @return mixed
     */
    public function select($select, $with = []);

    /**
     * Loads the model.
     *
     * @param Model $model
     */
    public function load($model);

    /**
     * Gets a model by ID.
     *
     * @param  int $id The model's ID
     * @return Model
     */
    public function find($id);

    /**
     * Get all instances of associated model filtering by custom field.
     *
     * @param  string $field field name
     * @param  mixed  $value field value
     * @param  array  $with
     * @return Collection
     */
    public function findBy($field, $value, $with = []);

    /**
     * Gets a model by ID.
     *
     * @param  int $id The model's ID
     * @return Model
     */
    public function first($id);

    /**
     * Get the first instance of associated model filtering by custom field.
     *
     * @param  string $field field name
     * @param  mixed  $value field value
     * @param  array  $with
     * @return Model
     */
    public function firstBy($field, $value, $with = []);

    /**
     * Get the first instance of associated model strictly filtering by custom field.
     *
     * @param  string $field field name
     * @param  mixed  $value field value
     * @param  array  $with
     * @return Model
     */
    public function firstByStrict($field, $value, $with = []);

    /**
     * Finds a model, if not exists it creates the model.
     *
     * @param  array $params
     * @param  array $delayed
     * @return Model
     */
    public function firstOrCreate($params, $delayed = []);

    /**
     * Finds a model, if not exists it returns a new model.
     *
     * @param  array $params
     * @param  array $delayed
     * @return Model
     */
    public function firstOrNew($params, $delayed = []);

    /**
     * Creates a model.
     *
     * @param  array $params The model fields
     * @return Model
     */
    public function create($params);

    /**
     * Updates a model.
     *
     * @param  int   $id     The model's ID
     * @param  array $params The model fields
     * @return Model
     */
    public function update($id, $params);

    /**
     * Deletes a model.
     *
     * @param  int $id The model's ID
     * @return bool
     */
    public function delete($id);

    /**
     * Get a new instance of model.
     *
     * @return Model
     */
    public function newModel();

    /**
     * Paginates a query.
     *
     * @param  query Query
     * @param  int         $page  Page to show
     * @param  int         $limit Items per page
     * @return json Json with the result
     *              - result: Array with the result
     *              - total: Total of items
     *              - page:   Current page
     *              - pages: Total of pages
     */
    public function paginate($query, $page, $limit);

    /**
     * Gets the model paginated.
     *
     * @param  int $page  Page to show
     * @param  int $limit Items per page
     * @return array Array with the result
     *               - result: Array with the result
     *               - total: Total of items
     *               - page:   Current page
     *               - pages: Total of pages
     */
    public function pagination($page = 0, $limit = 5);

    /**
     * Set paginate to true.
     *
     * @return $this
     */
    public function enablePagination();

    /**
     * Set paginate to false.
     *
     * @return $this
     */
    public function disablePagination();

    /**
     * Set the number of models to return per page.
     *
     * @param  int $perPage
     * @return $this
     */
    public function setPerPage($perPage);
}
