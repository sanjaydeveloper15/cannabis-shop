<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ModelScopes;
use DB, Exception;

class GuestCart extends Model
{
    use ModelScopes;

    protected $hidden = ['created_at','updated_at'];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function product_cost() {
        return $this->belongsTo(ProductCost::class);
    }

    public static function isProductAdded($product_cost_id,$guest_id){
    	return self::where('guest_id',$guest_id)->where('product_cost_id',$product_cost_id)->first();
    }

    public static function addToCart($req_data,$guest_id,$product_id,$amount){//type empty new add, 1 plus, 2 minus
        try{
            $found = self::where('guest_id',$guest_id)->where('product_id',$product_id)->where('product_cost_id',$req_data->product_cost_id)->first();
            if($found){
                $quantity = ($req_data->type==1) ? $found->quantity + 1 : $found->quantity - 1;
                if($req_data->type==2 && $quantity < 1){
                    return self::where('id',$found->id)->delete();
                }else{
                    return self::where('id',$found->id)->update(['quantity' => $quantity, 'amount' => $amount * $quantity]);    
                }
            }else{
                return self::insert([
                    'guest_id' => $guest_id,
                    'product_id' => $product_id,
                    'product_cost_id' => $req_data->product_cost_id,
                    'amount' => $amount,
                    'created_at' => date("Y-m-d H:i:s") 
                ]); 
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public static function guestCartList($guest_id){
        return self::with('product.images','product.product_discount','product_cost.quantity_option')->where('guest_id',$guest_id)->get();
    }

    public static function myCartCount($guest_id){
        return self::where('guest_id',checkValue($guest_id))->sum('quantity');
    }
}
