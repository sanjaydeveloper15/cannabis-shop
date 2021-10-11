<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ModelScopes;

class CategoryDiscount extends Model
{
    use ModelScopes;

    protected $hidden = ['created_at','updated_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'discount', 'type', 'status', 'created_at'
    ];
}
