<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DeviceType; 
use Validator, Str, DB, App, Session, Exception;

class DeviceTypeController extends Controller
{
    public $views;
    public function __construct(){
        $this->views = 'admin/device_types/';
    }

    /** 
     * device type view @get
     */ 
    public function index(Request $request){
    	$page_name = 'device_type';
    	return view($this->views.'device_types',compact('page_name'));
    }

    /** 
     * add new or update device types @post
     */ 
    public function device_type_request(Request $request){
    	DB::beginTransaction();
    	try{
    		$validator = Validator::make($request->all(), [ 
                'device_type_name' => 'required|max:18|unique:device_types,name,'.$request->edit_id
            ]);
            if ($validator->fails()) {
                return jsonResponse(1,$validator->getMessageBag()->toArray());
            }
            $found = DeviceType::find($request->edit_id);
            $data = ['name' => $request->device_type_name];
            if($found){//update
            	DeviceType::where('id',$found->id)->update(array_filter($data));
            	$msg = __('messages.updated',['attribute' => 'device type']);
            }else{//insert
            	$data['created_at'] = date("Y-m-d H:i:s");
            	DeviceType::insert($data);
            	$msg = __('messages.added',['attribute' => 'device type']);
            }
            DB::commit();
            return jsonResponse(3,$msg);
    	}catch(Exception $e){
    		DB::rollback();
            return jsonResponse(1,$e->getMessage());
        }
    }

    /** 
     * device types listing view @get
     */ 
    public function listing(Request $request, $type, $keyword=''){
    	$device_types = DeviceType::status($type)->search(decodeIt($keyword),'name')->orderByDesc('id')->get();
    	return view($this->views.'device_types_list', compact('device_types', 'keyword', 'type'));
    }
}
