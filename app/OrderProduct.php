<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ModelScopes;
use Illuminate\Support\Facades\Auth; 
use DB, Exception;

class OrderProduct extends Model
{
    use ModelScopes;

    protected $hidden = ['created_at','updated_at'];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function quantity_option(){
        return $this->hasOne(QuantityOption::class,'id','quantity_option_id');
    }

    public static function saveProducts($order_id,$user_id){
    	try{
    		$cart_items = Cart::with('product_cost')->with('product.product_discount')->where('user_id',$user_id)->get();
    		$arr = [];
            $total_items = 0;
            $product_name_str = ''; $product_name_arr = [];
    		foreach ($cart_items as $item) {
    			$discount = 0;
    			if($item->product->product_discount){
    				$discount = makeDiscountPrice($item->product_cost->cost,$item->product->product_discount->type,$item->product->product_discount->discount,1);	
    			}
    			$arr[] = ['order_id' => $order_id, 'product_id' => $item->product_id, 'quantity' => $item->quantity, 'quantity_option_id' => $item->product_cost->quantity_option_id, 'cost' => $item->product_cost->cost, 'discount' => $discount, 'created_at' => date("Y-m-d H:i:s")];
                $total_items += 1;
                $product_name_str = array_push($product_name_arr, $item->product->name);
    		}
            $product_name_str = implode(',',$product_name_arr);
            Order::where('id',$order_id)->update(['total_items'=>$total_items,'product_name_str'=>$product_name_str]);
    		return self::insert($arr);
    	}catch(Exception $e){
    		return false;
    	}
    }
}
