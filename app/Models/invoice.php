<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'invoice_product' , 'invoice_id', 'product_id');
    }

    public function customer()
    {
        return $this->belongsTo(customer::class);
    }
}
