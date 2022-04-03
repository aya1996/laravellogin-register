<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function invoice()
    {
        return $this->hasMany(invoice::class);
    }

    public function customer()
    {
        return $this->belongsTo(customer::class);
    }
}
