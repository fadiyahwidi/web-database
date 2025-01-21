<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Categories extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'categories';
    
    protected $primaryKey = '_id';
    
    protected $fillable = [
        'name',
    ];

    public function products()
    {
        return $this->hasMany(Products::class, 'category_id');
    }
}