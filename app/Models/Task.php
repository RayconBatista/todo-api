<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'todo_id',
        'status_id',
        'label',
        'is_completed'
    ];

    public function todo()
    {
        return $this->hasOne(Todo::class, 'id', 'todo_id');
        // return $this->hasOne(Todo::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
