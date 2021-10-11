<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category; 
use Validator, Str, DB, App, Session, Exception;

class CategoryController extends Controller
{
    public $views;
    public function __construct(){
        $this->views = 'admin/categories/';
    }
    /** 
     * manage categories view @get
     */ 
    public function index(Request $request){
        $page_name = 'category';
    	return view($this->views.'manage_categories',compact('page_name'));
    }

    /** 
     * add new or update categories @post
     */ 
    public function category_request(Request $request){
    	DB::beginTransaction();
    	try{
            $valid = (!empty($request->edit_id)) ? 'nullable' : 'required';
    		$validator = Validator::make($request->all(), [ 
                'category_icon' => $valid.'|mimes:jpeg,jpg,png,gif|max:512',
                'category_name' => 'required|max:18|unique:categories,name,'.$request->edit_id
            ]);
            if ($validator->fails()) {
                return jsonResponse(1,$validator->getMessageBag()->toArray());
            }
            $icon = '';
            if ($request->hasFile('category_icon'))
            {
                $result = $this->uploadFile('/category_images', $request, 'category_icon');
                if ($result['errorCode'] == '1')
                {
                    return response()->json(['errorCode' => '1', 'errorMsg' => $result['errorMsg']]);
                }
                $icon = $result['fileName'];
            }
            $found = Category::find($request->edit_id);
            $data = ['name' => $request->category_name, 'icon' => $icon];
            if($found){//update
            	Category::where('id',$found->id)->update(array_filter($data));
            	$msg = __('messages.updated',['attribute' => 'category']);
            }else{//insert
            	$data['created_at'] = date("Y-m-d H:i:s");
            	Category::insert($data);
            	$msg = __('messages.added',['attribute' => 'category']);
            }
            DB::commit();
            return jsonResponse(3,$msg);
    	}catch(Exception $e){
    		DB::rollback();
            return jsonResponse(1,$e->getMessage());
        }
    }

    /** 
     * manage categories listing view @get
     */ 
    public function listing(Request $request, $type, $keyword=''){
    	$categories = Category::status($type)->search(decodeIt($keyword),'name')->orderByDesc('id')->get();
    	return view($this->views.'manage_categories_content', compact('categories', 'keyword', 'type'));
    }
}
