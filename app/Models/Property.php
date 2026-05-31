<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'title', 'type', 'price', 'location', 'area', 'status', 'image',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }
}
