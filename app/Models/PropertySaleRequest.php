<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertySaleRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'seller_name',
        'seller_phone',
        'seller_email',
        'seller_national_id',
        'title',
        'type',
        'price',
        'city',
        'location',
        'area',
        'bedrooms',
        'description',
        'notes',
        'status',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
        'project_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'area' => 'decimal:2',
        'bedrooms' => 'integer',
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
