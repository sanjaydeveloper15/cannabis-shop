<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ModelScopes;
use Illuminate\Support\Facades\Auth; 
use DB, Exception;

class Payment extends Model
{
    use ModelScopes;

    protected $hidden = ['created_at','updated_at'];

    public static function savePayment($payment_mode,$order_id,$user_id,$payment_id){
    	try{
    		return self::insert([
    			'user_id' => $user_id,
    			'order_id' => $order_id,
    			'payment_method' => $payment_mode,
    			'payment_id' => $payment_id,
    			'created_at' => date("Y-m-d H:i:s")
    		]);
    	}catch(Exception $e){
    		return false;
    	}
    }
}
