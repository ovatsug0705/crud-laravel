<?php

namespace App\Interfaces;

use stdClass;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    /**
     * Return an item with defined id
     *
     * @param integer $id
     * @return array
     */
    function getById(int $id):? array;

    /**
     * Return all rows from database
     *
     * @return Collection
     */
    function all() : Collection;

    /**
     * Add a new item to database
     *
     * @param array $data
     * @return array|null
     */
    function add(array $data) : ?array;

    /**
     * Update an item in database
     *
     * @param integer $id
     * @param array $data
     * @return array|null
     */
    function update(int $id, array $data) : ?array;

    /**
     * Delete an item from database
     *
     * @param integer $id
     * @return boolean
     */
    function delete(int $id) : bool;

    /**
     * Return total of items in database
     *
     * @return integer
     */
    function count() : int;
}
