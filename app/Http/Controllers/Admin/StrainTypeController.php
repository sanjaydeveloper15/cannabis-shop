<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\StrainType; 
use Validator, Str, DB, App, Session, Exception;

class StrainTypeController extends Controller
{
    public $views;
    public function __construct(){
        $this->views = 'admin/strain_types/';
    }
    /** 
     * strain type view @get
     */ 
    public function index(Request $request){
    	$page_name = 'strain_types';
    	return view($this->views.'manage_strain_types',compact('page_name'));
    }

    /** 
     * add new or update strain types @post
     */ 
    public function strain_type_request(Request $request){
    	DB::beginTransaction();
    	try{
    		$validator = Validator::make($request->all(), [ 
                'strain_type_name' => 'required|max:18|unique:device_types,name,'.$request->edit_id
            ]);
            if ($validator->fails()) {
                return jsonResponse(1,$validator->getMessageBag()->toArray());
            }
            $found = StrainType::find($request->edit_id);
            $data = ['name' => $request->strain_type_name];
            if($found){//update
            	StrainType::where('id',$found->id)->update(array_filter($data));
            	$msg = __('messages.updated',['attribute' => 'strain type']);
            }else{//insert
            	$data['created_at'] = date("Y-m-d H:i:s");
            	StrainType::insert($data);
            	$msg = __('messages.added',['attribute' => 'strain type']);
            }
            DB::commit();
            return jsonResponse(3,$msg);
    	}catch(Exception $e){
    		DB::rollback();
            return jsonResponse(1,$e->getMessage());
        }
    }

    /** 
     * strain types listing view @get
     */ 
    public function listing(Request $request, $type, $keyword=''){
    	$strain_types = StrainType::status($type)->search(decodeIt($keyword),'name')->orderByDesc('id')->get();
    	return view($this->views.'strain_types_list', compact('strain_types', 'keyword', 'type'));
    }
}
