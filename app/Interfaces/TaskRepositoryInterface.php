<?php

namespace App\Interfaces;
use App\Interfaces\RepositoryInterface;

interface TaskRepositoryInterface extends RepositoryInterface
{
    /**
     * Return a item by userId passed
     * @param int $id
     * @return array|null
     */
    function getByUser(int $id) :? array;
}
