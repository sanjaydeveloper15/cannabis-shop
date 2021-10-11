<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ModelScopes;
use DB, Exception;

class Cart extends Model
{
    use ModelScopes;

    protected $hidden = ['created_at','updated_at'];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function product_cost() {
        return $this->belongsTo(ProductCost::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public static function myCartCount($user_id){
        return self::where('user_id',$user_id)->sum('quantity');
    }

    public static function addToCart($req_data,$user_id,$product_id,$amount){//type empty new add, 1 plus, 2 minus
        try{
            $found = self::where('user_id',$user_id)->where('product_id',$product_id)->where('product_cost_id',$req_data->product_cost_id)->first();
            if($found){
                $quantity = ($req_data->type==1) ? $found->quantity + 1 : $found->quantity - 1;
                if($req_data->type==2 && $quantity < 1){
                    return self::where('id',$found->id)->delete();
                }else{
                    return self::where('id',$found->id)->update(['quantity' => $quantity, 'amount' => $amount * $quantity]);    
                }
            }else{
                return self::insert([
                    'user_id' => $user_id,
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

    public static function isProductAdded($product_cost_id,$user_id){
    	return self::where('user_id',$user_id)->where('product_cost_id',$product_cost_id)->first();
    }

    public static function CartList($user_id){
        return self::with('product.images')->with('product.corresponding_product')->with('product.product_discount')->with('product_cost.quantity_option')->where('user_id',$user_id)->get();
    }

    public static function deleteMyCart($user_id){
        return self::where('user_id',$user_id)->delete();
    }

    public static function checkCartQuantity($user_id){
        $all = self::where('user_id',$user_id)->get();
        foreach ($all as $item) {
            $check = ProductCost::with('product')->where('id',$item->product_cost_id)->first();
            if($check->available_stock < $item->quantity){
                return ['status'=>false,'product_name'=>$check->product->name];
                break;
            }
        }
        return ['status'=>true];
    }
}
