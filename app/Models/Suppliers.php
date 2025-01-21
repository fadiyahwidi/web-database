<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Suppliers extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'suppliers';
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address'
    ];

    // Products relationship
    public function products()
    {
        return $this->hasMany(Products::class, 'supplier_id', '_id');
    }
}