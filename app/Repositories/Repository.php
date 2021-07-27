<?php

namespace App\Repositories;

use stdClass;
use mixed;
use Illuminate\Support\Collection;
use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class Repository implements RepositoryInterface
{
    /**
     * Repository model
     *
     * @var Model
     */
    protected $model;

    /**
     * Contructor method
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Return an item with defined id
     *
     * @param integer $id
     * @return array
     */
    public function getById(int $id):? array
    {
        $item = $this->model->find($id);

        if ($item != null) {
            $item = $item->toArray();
        } else {
            $item = null;
        }

        return $item;
    }

    /**
     * Return all rows from database
     *
     * @return Collection
     */
    public function all() : Collection
    {
        $items = $this->model
            ->all()
            ->toArray();
        $items = $this->arrayToStdClass($items);
        $items = new Collection($items);

        return $items;
    }

    /**
     * Add a new item to database
     *
     * @param array $data
     * @return array|null
     */
    public function add(array $data) : ?array
    {
        $item = $this->model
            ->create($data)
            ->toArray();

        return $item;
    }

    /**
     * Update an item in database
     *
     * @param integer $id
     * @param array $data
     * @return array|null
     */
    public function update(int $id, array $data) : ?array
    {
        $item = $this->model->find($id);

        if ($item != null) {
            $item->update($data);
            $item = $item->toArray();
        } else {
            $item = null;
        }

        return $item;
    }

    /**
     * Delete an item from database
     *
     * @param integer $id
     * @return boolean
     */
    public function delete(int $id) : bool
    {
        $item = $this->model->find($id);

        if ($item != null) {
            $item->delete();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Return total of items in database
     *
     * @return integer
     */
    public function count() : int
    {
        return $this->model->count();
    }

    /**
     * Convert array to stdClass
     *
     * @param array $array
     * @return stdClass
     */
    protected function arrayToStdClass(array $array) : stdClass
    {
        $object = new stdClass();

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (isset($value[0]) && is_array($value[0])) {
                    $value = $this->arrayToStdClass($value);
                    $value = new Collection($value);
                } else {
                    if (count($value) > 0) {
                        $value = $this->arrayToStdClass($value);
                    } else {
                        $value = null;
                    }
                }
            }
            $object->$key = $value;
        }

        return $object;
    }
}