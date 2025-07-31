<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     protected $fillable = ['outlet_id', 'name', 'image', 'description', 'price', 'stock', 'description'];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
}
