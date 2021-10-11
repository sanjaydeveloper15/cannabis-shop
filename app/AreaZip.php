<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ModelScopes;
use Session;
class AreaZip extends Model
{
    use ModelScopes;

    protected $hidden = ['created_at','updated_at'];

    public static function firstZip(){
    	$area_zip = self::first();
    	if(!empty(Session::get('pin'))){
    		return Session::get('pin');
    	}else{
    		return ($area_zip) ? $area_zip->area_code : '_ _ _ _ _' ;	
    	}
    }

    public static function checkZip($pin){
    	return self::where('area_code',$pin)->first();
    }
}
