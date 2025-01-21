<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Products extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'products';

    protected $fillable = [
        'name',
        'price',
        'stock',
        'category_id',
        'supplier_id'
    ];

    public function supplier()
    {
        return $this->belongsTo(Suppliers::class, 'supplier_id', '_id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id', '_id');
    }
}