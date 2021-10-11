<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ModelScopes;
use DB, Exception;

class ProductCost extends Model
{
	use ModelScopes;

    protected $hidden = ['created_at','updated_at'];

    public static function addCost($product_id,$option_id,$quantity,$cost,$stock){
    	try{
    		if(count($quantity) < 1){return false;}
    		$arr = [];
    		for($i=0; $i<count($quantity); $i++){
    			$arr[] = ['product_id' => $product_id, 'quantity_option_id' => $option_id[$i], 'quantity' => $quantity[$i], 'cost' => checkValue($cost[$i]), 'available_stock' => checkValue($stock[$i]), 'created_at' => date("Y-m-d H:i:s")];
    		}
	    	self::insert($arr);
	    	return true;
    	}catch(Exception $e){
    		return $e->getMessage();
    	}
    }

    public static function updateCost($product_id,$option_id,$quantity,$cost,$stock,$edit_id){
    	try{
    		if(count($quantity) < 1){return false;}
    		for($i=0; $i<count($quantity); $i++){
    			$arr = ['product_id' => $product_id, 'quantity_option_id' => $option_id[$i], 'quantity' => $quantity[$i], 'cost' => checkValue($cost[$i]), 'available_stock' => checkValue($stock[$i])];
    			self::where('id',$edit_id[$i])->update($arr);
	    	}
	    	return true;
    	}catch(Exception $e){
    		return $e->getMessage();
    	}
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function quantity_option(){
        return $this->hasOne(QuantityOption::class,'id','quantity_option_id');
    }

    public function guest_cart(){
        return $this->hasOne(GuestCart::class);
    }

    public function cart(){
        return $this->hasOne(Cart::class);
    }

    public function user_guest_cart(){
        if(isCustomerLogin()){
            return $this->cart()->where('user_id',Auth::user()->id);
        }else{
            return $this->guest_cart()->where('guest_id',checkValue(userGuestId()));    
        }
    }

    public function scopeFilterCost($query,$from,$to,$cat_id){
        try{
            $query->whereNotNull('id');
            if($to>0){
                $query->whereRaw('cost > '. $from . ' AND cost < '. $to);   
            }
            return $query;
        }catch(Exception $e){
            return false;
        }
    }

    public static function reduceQuantity($user_id){
        $all = Cart::where('user_id',$user_id)->get();
        foreach ($all as $cart_item) {
            $row = self::find($cart_item->product_cost_id);
            $row->available_stock = $row->available_stock - $cart_item->quantity;
            $row->update();
        }
        return true;
    }

    public static function stockWiseProducts($type){
        $query = self::with('product.category')->with('product.costs.quantity_option')->with('product.images');
        if($type==1){
            $query = $query->whereRaw('available_stock > 10');
        }else if($type==2){
            $query = $query->whereRaw('available_stock > 0 AND available_stock < 11');
        }else{
            $query = $query->where('available_stock',0);
        }
        return $query->paginate(24);
    }
}
