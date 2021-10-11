<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ModelScopes;

class StrainType extends Model
{
    use ModelScopes;

    protected $hidden = ['created_at','updated_at'];
}
