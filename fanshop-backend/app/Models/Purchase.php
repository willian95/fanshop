<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    public function purchaseProducts(){

        return $this->hasMany(PurchaseProduct::class);

    }

    public function user(){

        return $this->belongsTo(User::class);

    }

    public function trackings(){

        return $this->hasMany(Tracking::class);

    }

}
