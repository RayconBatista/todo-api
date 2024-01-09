<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'label', 'color'];

    public function project()
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }
}
