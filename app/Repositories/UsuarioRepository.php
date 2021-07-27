<?php

namespace App\Repositories;

use App\Models\Usuario;
use App\Repositories\Repository;
use App\Interfaces\UsuarioRepositoryInterface;

class UsuarioRepository extends Repository implements UsuarioRepositoryInterface
{
    /**
     * Constructor method
     */
    public function __construct()
    {
        parent::__construct(new Usuario);
    }

    /**
     * Return a item by email passed
     *
     * @param string $email
     * @return array|null
     */
    public function getByEmail(string $email) :? array
    {
        $item = $this->model
            ->where('email', $email)
            ->first();

        if (!empty($item)) {
            $item = $item->toArray();
        } else {
            $item = null;
        }

        return $item;
    }
}