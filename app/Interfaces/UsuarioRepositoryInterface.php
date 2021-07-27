<?php

namespace App\Interfaces;
use App\Interfaces\RepositoryInterface;

interface UsuarioRepositoryInterface extends RepositoryInterface
{
    /**
     * Return a item by email passed
     *
     * @param string $email
     * @return array|null
     */
    function getByEmail(string $email) :? array;
}
