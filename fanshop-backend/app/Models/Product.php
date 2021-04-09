<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable=["productId", "object", "searchType"];

    public function cart(){
        return $this->hasMany(Cart::class);
    }

}
