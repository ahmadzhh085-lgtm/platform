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

    public function getImageAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        if (str_starts_with($value, 'storage/')) {
            return asset($value);
        }

        return asset('storage/' . ltrim($value, '/'));
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }
}
