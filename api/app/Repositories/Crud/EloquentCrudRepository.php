<?php

namespace App\Repositories\Crud;

/**
 * @property bool                                paginate
 * @property \Illuminate\Database\Eloquent\Model model
 * @property int                                 perPage
 */
class EloquentCrudRepository implements CrudRepository
{
    /**
     * Indicates if query should be paginated.
     *
     * @var bool
     */
    protected $paginate = false;

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = null;

    /**
     * {@inheritdoc}
     */
    public function all($with = [], $order = null)
    {

        $query = $this->model->with($with);
        if (! empty($order)) {
            $query->orderBy($order);
        }

        return $query->get();
    }

    /**
     * {@inheritdoc}
     */
    public function select($select, $with = [])
    {
        return $this->model->with($with)->select($select)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function load($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        if (is_array($id)) {
            return $this->model->whereIn($this->model->getKeyName(), $id)->get();
        }

        return $this->model->findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findBy($field, $value, $with = [])
    {
        return $this->model->with($with)->where($field, 'LIKE', "%$value%")->get();
    }

    /**
     * {@inheritdoc}
     */
    public function findByStrict($field, $value, $with = [])
    {
        return $this->model->with($with)->where($field, 'LIKE', $value)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function first($id)
    {
        return $this->model->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function firstBy($field, $value, $with = [])
    {
        return $this->model->with($with)->where($field, 'LIKE', "%$value%")->first();
    }

    /**
     * {@inheritdoc}
     */
    public function firstByStrict($field, $value, $with = [])
    {
        return $this->model->with($with)->where($field, $value)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function firstOrCreate($params, $delayed = [])
    {
        return $this->model->firstOrCreate($params, $delayed);
    }

    /**
     * {@inheritdoc}
     */
    public function firstOrNew($params, $delayed = [])
    {
        return $this->model->firstOrNew($params, $delayed);
    }

    /**
     * {@inheritdoc}
     */
    public function create($params)
    {
        return $this->model->create($params);
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, $params)
    {
        $model = $this->model->findOrFail($id);

        $model->update($params);

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $model = $this->model->findOrFail($id);

        return $model->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function newModel()
    {
        return new $this->model();
    }

    /**
     * {@inheritdoc}
     */
    public function paginate($query, $page, $limit)
    {
        $page = intval($page);
        $count = $query->count();
        $pages = intval(ceil($count / $limit));

        $result = $query->skip($page * $limit)->limit($limit)->get();

        return [
            'result' => $result,
            'total' => $count,
            'page' => $page,
            'pages' => $pages,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function pagination($page = 0, $limit = 5)
    {
        return $this->paginate($this->model, $page, $limit);
    }

    /**
     * {@inheritdoc}
     */
    public function enablePagination()
    {
        $this->paginate = true;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function disablePagination()
    {
        $this->paginate = false;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;

        return $this;
    }
}
