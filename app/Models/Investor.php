<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name', 'phone', 'email', 'national_id', 'address',
    ];

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }
}
