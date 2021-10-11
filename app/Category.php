<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ModelScopes;

class Category extends Model
{
	use ModelScopes;

	public function __construct()
	{
		//code	
	}

	protected $hidden = ['created_at','updated_at'];	
	public static $image_path = "public/category_images";
	
	public function updateStatus(){
		return $this->update(['status' => ($this->status==1) ? 0 : 1 ]);
	}

	public function getImageUrl(){
		return makeImageURL($this->icon);
	}

	public function deleteImage(){
        deleteFile($this->icon);//static::$image_path."/".
    }

    public function products(){
    	return $this->hasMany(Product::class);
    }

    public function category_discount(){
        return $this->hasOne(CategoryDiscount::class);
    }

    public function limited_products(){
    	return $this->products()->limit(10);
    }

    public static function allCategoryProducts(){
    	return self::with('limited_products.costs.quantity_option','limited_products.costs.user_guest_cart','limited_products.images')->get();
    }
}
