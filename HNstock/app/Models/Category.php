<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public static function defaultCategory(): self
    {
        $result = new self([
            'name' => '--',
            'id' => 0
        ]);

        $result->isDefault = true;
        $result->id = 0;

        return $result;
    }
}
