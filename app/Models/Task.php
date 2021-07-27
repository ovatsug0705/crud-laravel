<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'finished',
        'title',
        'user_id',
    ];

    /**
     * The table's name attribute.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * Get the Usuário that owns the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuarios(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }
}
