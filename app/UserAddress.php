<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ModelScopes;
use Illuminate\Support\Facades\Auth;
use Exception;

class UserAddress extends Model
{
	use ModelScopes;

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'country_id', 'country_name', 'city_id', 'city_name', 'address' , 'latitude', 'longitude' , 'street_name' , 'apartment_name' , 'sector' , 'residential_name' , 'country_code' , 'mobile_number'
    ];

    protected $hidden = ['created_at','updated_at'];

    public static function addAddress($req_data){
    	try{
    		$data = myArray($req_data->all());
	    	unset($data['edit_id']);
            $country = Country::where('country_code',$req_data->country_id)->first();
            $city = City::select('name')->where('row_id',$data['city_id'])->first();
	    	$data['country_id'] = $country->country_id;
            $data['country_name'] = $country->country_name;
            $data['city_name'] = urldecode($city->name);
	    	$data['user_id'] = Auth::user()->id;
	    	$data['created_at'] = date("Y-m-d H:i:s");
	    	$sql = UserAddress::insert($data);
    	}catch(Exception $e){
    		return $e->getMessage();
    	}
    }

    public function updateAddress($req_data){
        try{
            $data = myArray($req_data->all());
            unset($data['edit_id']);
            $country = Country::where('country_code',$req_data->country_id)->first();
            $city = City::select('name')->where('row_id',$data['city_id'])->first();
            $data['country_id'] = $country->country_id;
            $data['country_name'] = $country->country_name;
            $data['city_name'] = urldecode($city->name);
            $data['user_id'] = Auth::user()->id;
            $data['created_at'] = date("Y-m-d H:i:s");
            $this->update($data);
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function country(){
        return $this->hasOne(Country::class,'country_id','country_id');
    }

    public static function isPinAvailable($pin){
        return AreaZip::where('area_code',$pin)->first();
    }

    public static function listing(){
        if(isCustomerLogin()){
            return self::where('user_id',Auth::user()->id)->orderByDesc('id')->get();
        }else{
            return self::where('user_id',0)->get();
        }
    }

    public static function details($id){
        return self::with('country')->where('id',$id)->first();
    }
}
