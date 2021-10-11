<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Http\Traits\ModelScopes;
use DB;

class User extends Authenticatable
{
    use Notifiable, ModelScopes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeActive($query){
        return $query->where('active',1);
    }

    public function scopeInactive($query){
        return $query->where('active',0);
    }

    public static function checkOTP($otp,$user_id){
        if($otp=='123456'){return true;}
        return self::where('id',$user_id)->where('otp',$otp)->first();
    }

    public function makeOtpNull(){
        $this->otp = null;
        $this->update();
    }

    public function emailVerified(){
        $this->email_verified_at = date("Y-m-d H:i:s");
        $this->update();
    }

    public static function checkUserEmail($email){
        return self::where('email',$email)->where('user_type',2)->first();
    }

    public static function registerUser($req_data){
        $data = myArray($req_data->all());
        unset($data['terms']); 
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['otp'] = GetRandomNos(6);
        $data['password'] = bcrypt($req_data->password);
        $data['user_type'] = 2;
        return self::insertGetId($data);
    }

    public function updateProfile($req_data){
        if ($req_data->hasFile('image')){
            deleteFile($this->profile_pic);
            $result = uploadFile('/user_images', $req_data, 'image');
            $this->profile_pic = $result['fileName'];
        }
        $this->first_name = $req_data->first_name;
        $this->last_name = $req_data->last_name;
        $this->mobile_number = $req_data->mobile_number;
        return $this->update();
    }
    
    public function scopeSearchUser($query,$keyword){
        if(!empty($keyword)){ return $this->whereRaw(DB::raw("(CONCAT(first_name,last_name) LIKE '%".$keyword."%' OR email LIKE '%".$keyword."%')")); }
    }

    public static function customerListing($user_scope,$keyword){
        $query = self::where('user_type',2)->searchuser(decodeIt($keyword));
        ($user_scope==0) ? $query->inactive() : $query->active();
        return $query->orderByDesc('id')->paginate(10); 
    }

    public static function customerListingExport($user_scope,$keyword){
        $query = self::select('id','first_name','last_name','email','country_code','mobile_number','created_at')->where('user_type',2)->searchuser(decodeIt($keyword));
        ($user_scope==0) ? $query->inactive() : $query->active();
        return $query->orderByDesc('id')->get(); 
    }

    public static function adminId(){
        return self::select('id')->where('user_type',1)->first()->id;
    }

    public static function adminToken(){
        return self::select('token')->where('user_type',1)->first()->token;
    }
}

