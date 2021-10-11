<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $hidden = ['created_at','updated_at'];

    public static function addSingleImage($req_data,$product_id){
    	$result = uploadFile('/product_images', $req_data, 'image');
    	return self::insert(['path' => $result['fileName'], 'product_id' => $product_id, 'created_at' => date("Y-m-d H:i:s")]);
    }
}
