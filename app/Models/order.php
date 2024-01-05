<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\Product;
use app\Models\Table;

class order extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_id',
        'product_id',
        'quantity',
        'status'
    ];

    public function table()
{
    return $this->belongsTo(Table::class);
}

public function products()
{
    return $this->belongsTo(Product::class);
}



}
