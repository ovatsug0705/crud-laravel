<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Repository;
use App\Interfaces\TaskRepositoryInterface;

class TaskRepository extends Repository implements TaskRepositoryInterface
{
    /**
     * Constructor method
     */
    public function __construct()
    {
        parent::__construct(new Task);
    }

    /**
     * Return a item by userId passed
     * 
     * @param int $id
     * @return array|null
     */
    public function getByUser($id) :? array
    {
        $items = $this->model
            ->where('user_id', $id)
            ->get();

        if (!empty($items)) {
            $items = $items->toArray();
        } else {
            $items = null;
        }

        return $items;
    }
}