<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPurchaseRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'buyer_name',
        'buyer_phone',
        'buyer_email',
        'buyer_national_id',
        'offer_amount',
        'offer_price',
        'notes',
        'status',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'offer_amount' => 'decimal:2',
        'reviewed_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
