<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ModelScopes;

class QuantityOption extends Model
{
	use ModelScopes;
	
    protected $hidden = ['created_at','updated_at'];

 //    public function quantity_option() {
	//     return $this->belongsTo(QuantityOption::class);
	// }
}
