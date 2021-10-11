<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ModelScopes;
use Illuminate\Support\Facades\Auth; 
use DB, Exception;

class Product extends Model
{
	use ModelScopes;

    protected $hidden = ['created_at','updated_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'category_id', 'device_type_id', 'brand_id', 'strain_type_id', 'product_id_show', 'sku_code', 'potency', 'corresponding_product_id'
    ];

    public static function productCategories(){
    	return Category::ActiveStatus()->orderBy('name','asc')->get();
    }

    public static function productDeviceType(){
    	return DeviceType::ActiveStatus()->orderBy('name','asc')->get();
    }

    public static function productBrands(){
    	return Brand::ActiveStatus()->orderBy('name','asc')->get();
    }

    public static function productStrainType(){
    	return StrainType::ActiveStatus()->orderBy('name','asc')->get();
    }

    public static function productQuantityOptions(){
    	return QuantityOption::ActiveStatus()->orderBy('name','asc')->get();
    }

    public static function addProduct($req_data){
    	try{
    		return self::insertGetId(array_filter([
	    		'user_id' => Auth::user()->id,
	    		'name' => $req_data->name,
	    		'description' => urlencode($req_data->description),
	    		'category_id' => $req_data->category,
	    		'device_type_id' => checkEmpty($req_data->device_type),
	    		'brand_id' => checkEmpty($req_data->brand),
	    		'strain_type_id' => checkEmpty($req_data->strain_type),
                'product_id_show' => checkEmpty($req_data->product_id_show),
                'sku_code' => checkEmpty($req_data->sku_code),
                'potency' => checkEmpty($req_data->potency),
                'corresponding_product_id' => checkEmpty($req_data->corresponding_product_id),
	    		'created_at' => date("Y-m-d H:i:s")
	    	]));
    	}catch(Exception $e){
    		return false;
    	}
    }

    public function updateProduct($req_data){
    	try{
	    	$arr = [
	    		'name' => $req_data->name,
	    		'description' => urlencode($req_data->description),
	    		'category_id' => $req_data->category,
	    		'device_type_id' => checkEmpty($req_data->device_type),
	    		'brand_id' => checkEmpty($req_data->brand),
	    		'strain_type_id' => checkEmpty($req_data->strain_type),
                'product_id_show' => checkEmpty($req_data->product_id_show),
                'sku_code' => checkEmpty($req_data->sku_code),
                'corresponding_product_id' => checkEmpty($req_data->corresponding_product_id),
                'potency' => checkEmpty($req_data->potency),
	    	];
	    	//print_r($arr);
	    	return $this->update(array_filter($arr));
    	}catch(Exception $e){
    		return false;
    	}
    	
    }

    public function deleteImages(){
    	$images = ProductImage::where('product_id',$this->id)->get();
    	foreach ($images as $image) {
    		deleteFile($image->path);
    		$image->delete();
    	}
    	return true;
    }

    public function category(){
    	return $this->hasOne(Category::class,'id','category_id');
    }

    public function images(){
    	return $this->hasOne(ProductImage::class);
    }

    public function device_type(){
    	return $this->hasOne(DeviceType::class,'id','device_type_id');
    }

    public function product_discount(){
        return $this->hasOne(ProductDiscount::class)->where('status',1);
    }

    public function brand(){
    	return $this->hasOne(Brand::class,'id','brand_id');
    }

    public function strain_type(){
    	return $this->hasOne(StrainType::class,'id','strain_type_id');
    }

    public function fake_product(){
        return $this->hasOne(FakeProduct::class);
    }

    public function corresponding_product(){
        return $this->hasOne(CorrespondingProduct::class,'id','corresponding_product_id');
    }

    public function costs(){
    	return $this->hasMany(ProductCost::class);
    }

    public function costInStock(){
        return $this->hasMany(ProductCost::class)->whereRaw('available_stock > 10');
    }

    public function costFewStock(){
        return $this->hasMany(ProductCost::class)->whereRaw('available_stock < 10 AND available_stock > 0');
    }

    public function costOutOfStock(){
        return $this->hasMany(ProductCost::class)->where('available_stock',0);
    }

    public function scopeFilter($query,$from,$to,$cat_id){
    	$query->whereNotNull('id');
    	// if($to>0){
    	// 	$query->whereRaw('product_costs.cost > '. $from . ' AND product_costs.cost < '. $to);	
    	// }
    	if(!empty($cat_id)){
    		$query->where('category_id',$cat_id);
    	}
    	return $query;
    }

    public static function latestProducts(){
        return self::with('category')->with('product_discount')->with('costs.quantity_option')->with('costs.user_guest_cart')->with('images')->ActiveStatus()->orderByDesc('products.id')->limit(10)->get();
    }

    public static function productDetails($product_id){
        return self::with('category')->with('device_type')->with('brand')->with('strain_type')->with('product_discount')->with('costs.quantity_option')->with('corresponding_product')->with('images')->where('id',$product_id)->first();
    }

    public static function similarProducts($category_id,$expect_product_id){
        return self::with('category')->with('product_discount')->with('costs.quantity_option')->with('costs.user_guest_cart')->with('images')->where('category_id',$category_id)->whereRaw('id!='.$expect_product_id)->ActiveStatus()->orderByDesc('products.id')->limit(10)->get();
    }

    public static function productListing($req_data){
        $query = self::with('category')->with('product_discount')->with('costs.quantity_option')->with('costs.user_guest_cart')->with('images')->ActiveStatus();
        if(!empty($req_data->category_id)){
            $query->whereIn('category_id',explode(',',$req_data->category_id));  
        }
        if(!empty($req_data->brand_id)){
            $query->whereIn('brand_id',explode(',',$req_data->brand_id));
        }
        if(!empty($req_data->device_type_id)){
            $query->whereIn('device_type_id',explode(',',$req_data->device_type_id));
        }
        if(!empty($req_data->strain_type_id)){
            $query->whereIn('strain_type_id',explode(',',$req_data->strain_type_id));
        }
        if($req_data->category_id==0){
            $query->orderByDesc('id');
        }

        return $query->paginate(30);
    }

    public static function getCategoryID($product_id){
        return self::select('category_id')->where('id',$product_id)->first()->category_id;
    }

}
