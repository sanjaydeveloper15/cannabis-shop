<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ModelScopes;

class FakeProduct extends Model
{
	use ModelScopes;

    protected $hidden = ['created_at','updated_at'];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public static function addFakeData($req_data,$product_id){
    	$result = uploadFile('/fake_product_images', $req_data, 'fake_image');
    	return self::insert(['name' => $req_data->fake_name, 'image' => $result['fileName'], 'product_id' => $product_id, 'created_at' => date("Y-m-d H:i:s")]);
    }

    public static function updateFakeData($req_data,$product_id,$is_fake_image){
    	if($is_fake_image==1){
    		$result = uploadFile('/fake_product_images', $req_data, 'fake_image');
    		return self::where('product_id',$product_id)->update(['name' => $req_data->fake_name, 'image' => $result['fileName']]);	
    	}
    	return self::where('product_id',$product_id)->update(['name' => $req_data->fake_name]);
    }

    public static function deleteImage($product_id){
    	$image = self::where('product_id',$product_id)->first();
    	if($image){
    		deleteFile($image->image);
    	}
    	return true;
    }
}
