<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ModelScopes;
use Illuminate\Support\Facades\Auth; 
use DB, Exception;

class CorrespondingProduct extends Model
{
    use ModelScopes;

    protected $hidden = ['created_at','updated_at'];	

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'cost', 'image', 'product_id_show', 'created_at', 'updated_at'
    ];

    public static function addProduct($req_data){
    	try{
    		return self::insertGetId(array_filter([
	    		'user_id' => Auth::user()->id,
	    		'name' => $req_data->name,
	    		'description' => urlencode($req_data->description),
                'product_id_show' => checkEmpty($req_data->product_id_show),
                'image' => self::uploadImage($req_data),
                'cost' => $req_data->cost,
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
                'product_id_show' => checkEmpty($req_data->product_id_show),
                'cost' => $req_data->cost,
                'image' => self::uploadImage($req_data)
	    	];
	    	return $this->update(array_filter($arr));
    	}catch(Exception $e){
    		return false;
    	}
    }

    public static function uploadImage($req_data,$image = ''){
    	if ($req_data->hasFile('image')){
    		$result = uploadFile('/corresponding_product_images', $req_data, 'image');
    		$image = $result['fileName'];
    	}
    	return $image;
    }

    public function deleteImage(){
    	deleteFile($this->image);
    }
}
