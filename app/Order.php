<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ModelScopes;
use DB, Exception;

class Order extends Model
{
    use ModelScopes;

    protected $hidden = ['created_at','updated_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id_show', 'user_id', 'invoice_no', 'price', 'tax', 'discount', 'total_price', 'status', 'created_at', 'product_name_str', 'total_items'
    ];

    public static function placeOrder($user_id,$price,$discount,$total_price){
    	try{
    		return self::insertGetId([
    			'order_id_show' => genOrderID($user_id),
    			'user_id' => $user_id,
    			'invoice_no' => genInvNo($user_id),
    			'price' => $price,
    			'discount' => $discount,
    			'total_price' => $total_price,
    			'created_at' => date("Y-m-d H:i:s")
    		]);
    	}catch(Exception $e){
    		return false;
    	}
    }

    public static function listing($user_id,$status,$order_id=''){
        if(!empty($order_id)){
            return self::where('user_id',$user_id)->where('id',$order_id)->whereIn('status',$status)->orderByDesc('id')->paginate(20);
        }else{
            return self::where('user_id',$user_id)->whereIn('status',$status)->orderByDesc('id')->paginate(10);    
        }
    }

    public static function adminListing($status,$keyword,$req_data){
        $query = self::where('status',$status);
        if(!empty($keyword)){
            $keyword = decodeIt($keyword);
            $query = $query->search($keyword,'order_id_show');
        }
        if(isset($req_data->from_amount)){
            $query = $query->whereRaw('price >= '.$req_data->from_amount.' AND price <= '.$req_data->to_amount);
        }
        if($req_data->start_date!='' && $req_data->end_date!=''){
            $req_data->start_date = decodeIt($req_data->start_date);
            $req_data->end_date = decodeIt($req_data->end_date);
            $query = $query->whereRaw("DATE(created_at) >= '".$req_data->start_date."' AND DATE(created_at) <= '".$req_data->end_date."'");
        }
        return $query->orderByDesc('id')->paginate(20);
    }

    public function order_address(){
        return $this->hasOne(OrderAddress::class);
    }

    public function order_products(){
        return $this->hasMany(OrderProduct::class);
    }

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public static function changeStatus($order_id,$status){
        if($status==1){
            $column = 'in_process_at';
        }else if($status==2){
            $column = 'shipped_at';
        }else if($status==3){
            $column = 'completed_at';
        }
        return self::where('id',$order_id)->update(['status'=>$status, $column => date("Y-m-d H:i:s")]);
    }

    public static function details($order_id){
        return self::where('id',$order_id)->with('user')->with('order_address')->with('order_products.quantity_option')->with('order_products.product')->first();
    }
}
