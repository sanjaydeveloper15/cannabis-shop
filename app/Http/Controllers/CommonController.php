<?php
/*
| Custom common controller
| @dev
| @laravel
| @sanjaykumarwebs
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\User; 
use App\Notification;
use DB, Exception;

class CommonController extends Controller
{
    
    /*
    | change status of single row of any table
    */
    public function changeStatus(Request $request)
    {
    	DB::beginTransaction();
    	try{
    		$current = ($request->current==1) ? 0 : 1;
	   		$column  = (empty($request->column)) ? 'active' : $request->column;
	        if(!empty($request->set)){
	            $current = $request->set;
	        }
	    	$sql = DB::table($request->tableName)->where('id', $request->rowId)->update([$column => $current]);
	    	DB::commit();
	        SQLStatus($sql);
    	}catch(Exception $e){
    		DB::rollback();
    		return 0;
    	}
    }
    
    /*
    | delete single row of any table
    */
    public function deleteRow(Request $request){
    	DB::beginTransaction();
    	try{
            $found = DB::table($request->tableName)->find($request->rowId);
            deleteFile(@$found->icon); deleteFile(@$found->image);
            if($request->tableName=='banners'){
                deleteFile($found->large_banner);
            }
	        if($request->tableName=='category_discounts'){//remove same category product discount too
                $category_id = DB::table('category_discounts')->where('id',$request->rowId)->first()->category_id;
                DB::table('product_discounts')->where('category_id',$category_id)->delete();

            }
            $sql = DB::table($request->tableName)->where('id', '=', $request->rowId)->delete();

            DB::commit();
	        SQLStatus($sql);
        }catch(Exception $e){
    		DB::rollback();
    		return 0;
    	}
    }

    /*
    | get single row of any table
    */
    public function getRow(Request $request){
        $sql = DB::table($request->tableName)->where('id', '=', $request->rowId)->first();
        return json_encode($sql);
    }

    /*
    | make null column of any table
    */
    public function makeNull(Request $request){
    	DB::beginTransaction();
    	try{
	        $sql = DB::table($request->tableName)->where('id', '=', $request->rowId)->update([$request->columnName => null]);
            DB::commit();
	        SQLStatus($sql);
        }catch(Exception $e){
    		DB::rollback();
    		return 0;
    	}
    }

    /*
    | for admin and user both
    */
    public function save_token(Request $request){
        DB::beginTransaction();
        try{
            if(isCustomerLogin()){
                User::where('id',Auth::user()->id)->update(['device_id' => $request->device_id, 'token' => $request->token]);
                DB::commit();
                return 1;
            }
        }catch(Exception $e){
            DB::rollback();
            return 0;
        }
    }
}
