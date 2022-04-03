<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoiceProduct extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'invoice_product'
    ;
    public function invoice()
    {
        return $this->hasMany(invoice::class);
    }

    public function product()
    {
        return $this->belongsTo(products::class);
    }
    
}
