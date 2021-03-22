<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'price',
        'is_stock',
    ];
    public function getIsStockAttribute($value)
    {
        if($value==1){
            return "New";
        }else{
            return "Processed";
        }
    }
   
}
