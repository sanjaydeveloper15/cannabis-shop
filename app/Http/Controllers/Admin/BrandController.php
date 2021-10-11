<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Brand; 
use Validator, Str, DB, App, Session, Exception;

class BrandController extends Controller
{
    public $views;
    public function __construct(){
        $this->views = 'admin/brands/';
    }
    /** 
     * manage brand view @get
     */ 
    public function index(Request $request){
    	$page_name = 'brands';
    	return view($this->views.'manage_brands',compact('page_name'));
    }

    /** 
     * add new or update brand @post
     */ 
    public function brand_request(Request $request){
    	DB::beginTransaction();
    	try{
    		$validator = Validator::make($request->all(), [ 
                'brand_name' => 'required|max:18|unique:brands,name,'.$request->edit_id
            ]);
            if ($validator->fails()) {
                return jsonResponse(1,$validator->getMessageBag()->toArray());
            }
            $found = Brand::find($request->edit_id);
            $data = ['name' => $request->brand_name];
            if($found){//update
            	Brand::where('id',$found->id)->update(array_filter($data));
            	$msg = __('messages.updated',['attribute' => 'brand']);
            }else{//insert
            	$data['created_at'] = date("Y-m-d H:i:s");
            	Brand::insert($data);
            	$msg = __('messages.added',['attribute' => 'brand']);
            }
            DB::commit();
            return jsonResponse(3,$msg);
    	}catch(Exception $e){
    		DB::rollback();
            return jsonResponse(1,$e->getMessage());
        }
    }

    /** 
     * brands listing view @get
     */ 
    public function listing(Request $request, $type, $keyword=''){
    	$brands = Brand::status($type)->search(decodeIt($keyword),'name')->orderByDesc('id')->get();
    	return view($this->views.'manage_brands_content', compact('brands', 'keyword', 'type'));
    }
}
