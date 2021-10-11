<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ModelScopes;
use Illuminate\Support\Facades\Auth; 
use DB, Exception;

class OrderAddress extends Model
{
    use ModelScopes;

    protected $hidden = ['created_at','updated_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id','type', 'country_id', 'country_name', 'city_id', 'city_name', 'address' , 'latitude', 'longitude' , 'street_name' , 'apartment_name' , 'sector' , 'residential_name' , 'country_code' , 'mobile_number', 'area_code'
    ];

    public static function saveAddress($order_id,$add_array){
    	try{
    		unset($add_array['id']); unset($add_array['status']);
    		$add_array['order_id'] = $order_id;
    		$add_array['created_at'] = date("Y-m-d H:i:s");
    		return self::insert($add_array);
    	}catch(Exception $e){
    		return false;
    	}
    }
}
