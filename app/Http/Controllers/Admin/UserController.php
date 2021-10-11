<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\User; 
use App\Notification;
use Validator, Str, DB, App, Session, Exception;
class UserController extends Controller
{
    /** 
     * admin login view
     */     
    public function index(){ 
    	return redirect('admin/login');
    }

    /** 
     * admin login view
     */     
    public function login(){ 
    	return view('admin/login');
    }

    /** 
     * admin login authentication
     * 
     * @return \Illuminate\Http\Response 
     */  
    public function admin_login(Request $request){
        try{
            $validator = Validator::make($request->all(), [ 
                'email' => 'required',
                'password' => 'required'
            ],['email.required' => 'Email address field is required.','email.exists' => 'The selected email address is invalid.']);
            if ($validator->fails()) {
                return jsonResponse(1,$validator->getMessageBag()->toArray());
            }
            $found_admin = User::select('id')->where('email',$request->email)->where('user_type',1)->first();
            if($found_admin){
                if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
                    $user = Auth::user();
                    Session::push('admin_session_data', $user);
                    return jsonResponse(3,'You have successfully logging in.');
                }else{
                    return jsonResponse(2,'Sorry, password not matched!');
                }
            }else{
                return jsonResponse(2,'Your email id or password does not matched!');
            }
        }catch(Exception $e){
            return jsonResponse(1,$e->getMessage());
        }
    }

    public function popup_notif(Request $request){
        $notifications = Notification::my_notif_list(Auth::user()->id,1);
        Notification::viewed_badge(Auth::user()->id);
        return view('admin.inc.notif_list', compact('notifications'));
    }

    public function notif_count(Request $request){
        return Notification::badge_count(Auth::user()->id);
    }

    public function notif_list(Request $request){
        $notifications = Notification::my_notif_list(Auth::user()->id);
        $page_name = Session::get('page_name');
        return view('admin.notifications', compact('notifications','page_name'));   
    }

    public function read_notif(Request $request,$id){
        Notification::viewed_single(Auth::user()->id,$id);
    }

    /**
     * exit from admin panel.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->forget(['admin_session_data']);
        Session::flush();
        return redirect('admin/login');
    }
}
