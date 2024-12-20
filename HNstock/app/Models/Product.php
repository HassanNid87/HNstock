<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'image',
        'priceA',
        'priceV',
        'category_id',
        'codebare',
        'etagere',
        'unite',
        'stockmax',
        'stockmin',


    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withDefault(fn() => Category::defaultCategory());
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

}
