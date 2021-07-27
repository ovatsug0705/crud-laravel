<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * The table's name attribute.
     *
     * @var string
     */
    protected $table = 'usuarios';

    /**
     * Get all of the Task for the Usuario
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function task(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
