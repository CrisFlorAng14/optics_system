<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Inventory
 *
 * @property $id
 * @property $type
 * @property $fk_idProduct
 * @property $created_at
 * @property $updated_at
 *
 * @property Product $product
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Inventory extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['type', 'fk_idProduct'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'fk_idProduct', 'id');
    }
    
}
