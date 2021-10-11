<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ModelScopes;
use DB, Exception;

class Notification extends Model
{
    use ModelScopes;

    protected $hidden = ['updated_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message', 'user_id', 'for_all_user', 'obj_type', 'obj_id', 'badge_viewed', 'viewed', 'created_at'
    ];

    public static function badge_count($user_id){
    	return self::where('badge_viewed',0)->where('user_id',$user_id)->count();
    }

    public static function viewed_badge($user_id){
    	return self::where('user_id',$user_id)->update(['badge_viewed'=>1]);
    }

    public static function viewed_single($user_id,$notif_id){
    	return self::where('user_id',$user_id)->where('id',$notif_id)->update(['viewed'=>1]);
    }

    public static function my_notif_list($user_id,$for_popup=0){
    	if($for_popup==1){
    		return self::where('user_id',$user_id)->limit(5)->orderByDesc('id')->get();
    	}else{
    		return self::where('user_id',$user_id)->orderByDesc('id')->get();	
    	}
    }

    public static function save_notif($msg,$obj_id,$obj_type,$user_id){
    	try{
    		return self::insertGetId([
    			'user_id' => $user_id,
    			'message' => $msg,
    			'obj_id' => $obj_id,
    			'obj_type' => $obj_type,
    			'created_at' => date("Y-m-d H:i:s")
    		]);
    	}catch(Exception $e){
    		return jsonResponse(1,$e->getMessage());
    	}
    }
}
