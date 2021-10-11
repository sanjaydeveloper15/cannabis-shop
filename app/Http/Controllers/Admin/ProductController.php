<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\ProductImage;
use App\ProductCost;
use App\FakeProduct;
use App\CorrespondingProduct;
use App\Category;
use Validator, Str, DB, App, Session, Exception;

class ProductController extends Controller
{
    public $views;
    public function __construct(){
        $this->views = 'admin/products/';
    }
	
    /** 
     * manage products view @get
     */ 
    public function index(Request $request){
        $page_name = 'products';
        $categories = Product::productCategories();
        $max_amount = ProductCost::orderBy('cost','desc')->first();
        $max_amount = ($max_amount) ? $max_amount->cost : 1;
    	return view($this->views.'manage_products',compact('page_name','categories','max_amount'));
    }

    /** 
     * add/edit products view @get
     */ 
    public function add_edit(Request $request, $type, $id=''){
    	$page_name = 'products';
    	$categories = Product::productCategories();
    	$device_types = Product::productDeviceType();
    	$strain_types = Product::productStrainType();
    	$brands = Product::productBrands();
    	$quantity_options = Product::productQuantityOptions();
        $corresponding_products = CorrespondingProduct::activeStatus()->get();
    	$edit_mode = false;$data = '';$title = 'Add New Product';
    	if($type=='edit'){
    		$edit_mode = true;$title = "Edit Product";
    		$data = Product::with('costs')->with('images')->with('fake_product')->where('id',$id)->first();
    	}
        return view($this->views.'products_add_edit',compact('page_name','categories','device_types','strain_types','brands','quantity_options','edit_mode','data','title','corresponding_products'));
    }

    /** 
     * add new or update product @post
     */ 
    public function product_request(Request $request){
    	DB::beginTransaction();
    	try{
    		$valid = (!empty($request->edit_id)) ? 'nullable' : 'required';
    		$validator = Validator::make($request->all(), [ 
                'image' => $valid.'|mimes:jpeg,jpg,png,gif|max:2048',
                'name' => 'required|max:70',
                'description' => 'required',
                'category' => 'required',
                'strain_type' => 'required',
                'device_type' => 'required',
                // 'fake_name' => 'required',
                // 'fake_image' => $valid.'|mimes:jpeg,jpg,png,gif|max:2048',
                'brand' => 'required',
                'cost.*' => 'required',
                'quantity.*' => 'required|integer',
                'available_stock.*' => 'required|integer',
                'sku_code' => 'nullable|unique:products,sku_code,'.$request->edit_id.'|max:100',
                'product_id_show' => 'nullable|unique:products,product_id_show,'.$request->edit_id.'|max:24|string',
                'potency' => 'nullable|max:16|string'
            ]);
            if ($validator->fails()) {
                return jsonResponse(1,$validator->getMessageBag()->toArray());
            }
            if(!empty($request->edit_id)){//update
            	$product = Product::find($request->edit_id);
            	if(!$product){return jsonResponse(2,__('messages.sorry_msg'));}
            	$update = $product->updateProduct($request);
            	if(!$update){return jsonResponse(2,__('messages.sorry_msg'));}
            	if ($request->hasFile('image')){
            		$product->deleteImages();
					ProductImage::addSingleImage($request,$product->id);
            	}
            	$save_costing = ProductCost::updateCost($product->id, $request->option_id, $request->quantity, $request->cost, $request->available_stock, $request->product_cost_id);
                // $is_fake_image = 0;
                // if ($request->hasFile('fake_image')){
                //     FakeProduct::deleteImage($product->id);
                //     $is_fake_image = 1;
                // }
                // $save_fake_data = FakeProduct::updateFakeData($request,$product->id,$is_fake_image);
            	$msg = __('messages.updated',['attribute' => 'product']);
            }else{//insert
            	$product_id = Product::addProduct($request);
            	if(!$product_id){return jsonResponse(2,__('messages.sorry_msg'));}
            	$save_image = ProductImage::addSingleImage($request,$product_id);
            	$save_costing = ProductCost::addCost($product_id, $request->option_id, $request->quantity, $request->cost, $request->available_stock);
                // $save_fake_data = FakeProduct::addFakeData($request,$product_id);	
  				$msg = __('messages.added',['attribute' => 'product']);
            }
            DB::commit();
            return jsonResponse(3,$msg);
    	}catch(Exception $e){
    		DB::rollback();
            return jsonResponse(2,$e->getMessage());
        }
    }

    /** 
     * products listing view @get
     */ 
    public function listing(Request $request, $type, $keyword='',$from='',$to='',$cat_id=''){
    	$products = Product::with('category','costs.quantity_option','images')->status($type)->search(decodeIt($keyword),'name')->filter($from,$to,$cat_id)->orderByDesc('products.id')->paginate(24);
    	//echo $products;die;
    	//print_r(json_encode($products));die;
    	return view($this->views.'products_list', compact('products', 'keyword', 'type'));
    }

    /** 
     * product details view @get
     */ 
    public function details(Request $request,$product_id){
        $page_name = 'products';
        $product = Product::productDetails($product_id);
        if(!$product){return 'Not found!';}
        $title = 'Product Details'; $edit_mode = false;
        return view($this->views.'details',compact('page_name','product','title','edit_mode'));
    }
}
