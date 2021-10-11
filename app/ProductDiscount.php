<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ModelScopes;

class ProductDiscount extends Model
{
    use ModelScopes;

    protected $hidden = ['created_at','updated_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'product_id', 'discount', 'type', 'status', 'created_at'
    ];
}
