<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Routing\Controller as BaseController;
use App\GuestCart;
use App\Cart;
use App\Notification;
use Str, Exception, Session, Cookie;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function generateRandomString()
    {
        return Str::random(10);
    }

    protected function uploadFile($targetDir, $request, $fileName)
    {
        $file = $request->file($fileName);
        $ext = $file->getClientOriginalExtension();
        $newFileName = date('YmdHis') . time() . $this->generateRandomString() . '.' . $ext;
		$path = $request->file($fileName)->storeAs('public' . $targetDir, $newFileName);
		if ($path)
        {
            return ['errorMsg' => "File successfully uploaded.", 'errorCode' => 0, 'fileName' => $path];
        }
        else
        {
            return ['errorMsg' => "Sorry, there was an error uploading your file.", 'errorCode' => 1];
        }
    }

    protected function is_customer_login(){
        return session()->has('user_session_data');
    }

    //guest user cart item move to cart
    protected function cartManipulation($user_id){
        try{
            $guest_id = $this->get_guest_id();
            $get = GuestCart::where('guest_id',$guest_id)->get();
            if(!$get->isEmpty()){
                foreach ($get as $list) {
                    $found = Cart::where('user_id',$user_id)->where('product_id',$list->product_id)->first();
                    if(!$found){
                        $data = array(
                            'user_id' => $user_id,
                            'product_id' => $list->product_id,
                            'product_cost_id' => $list->product_cost_id,
                            'quantity' => $list->quantity,
                            'amount' => $list->amount,
                            'created_at' => date("Y-m-d H:i:s")
                        );
                        Cart::insert($data);
                    }
                }
                GuestCart::where('guest_id',$guest_id)->delete();
            }
            return 1;
        }catch(Exception $e){
            return 0;
        }
    }

    public function get_guest_id(){
        if(Cookie::get('can_guest_id') !== null){
            $guest_id = Cookie::get('can_guest_id');
        }else{
            $guest_id = guestId();
            Cookie::queue('can_guest_id', guestId(), '14400');//10 days
        }
        return $guest_id;
    }

    protected function cartTotals(){//1 totalPayable, 2 payableAmount, 3 discountAmount
        $my_cart = $this->get_my_cart();
        $totalPayable = 0; $payableAmount = 0; $discountAmount = 0;
        if(!$my_cart->isEmpty()){
            foreach ($my_cart as $list) {
                $totalPayable += $list->quantity * $list->product_cost->cost;
                if($list->product_cost->product->product_discount){
                  $list->product_cost->cost = makeDiscountPrice($list->product_cost->cost,$list->product_cost->product->product_discount->type,$list->product_cost->product->product_discount->discount);
                } 
                $payableAmount += $list->quantity * $list->product_cost->cost; 
            }
        }
        $discountAmount = customRound($totalPayable) - customRound($payableAmount);
        return ['totalPayable' => $totalPayable, 'payableAmount' => $payableAmount, 'discountAmount' => $discountAmount];
    }

    public function get_my_cart(){
        if(isCustomerLogin()){
            $my_cart = Cart::CartList(Auth::user()->id);
        }else{
            $my_cart = GuestCart::guestCartList(userGuestId());    
        }
        return $my_cart;
    }

    protected function sendWebPush($user_token,$title,$body,$noti_url)
    {
        if(!is_null($user_token) && !empty($user_token)){
            $user_web_token[] = $user_token;
            //echo '<pre>'; print_r($user_web_token);die;
            $fields = ['registration_ids' => $user_web_token, 'notification' => array(
                'title' => $title,
                'body' => $body,
                'icon' => asset('public/website/img/logo.png'),
                'click_action' => config('app.url').$noti_url
            ) ];

            $fcmApiKey = 'AAAAg7O57zs:APA91bErv31RjnoQM9xkTKLWyujcC-T7i-87E-_NH83QB3N6uFEcTiMOoODEkabJFy4clWujuUs24-060VelnsflVlqtdpXg4b30A3v_Ig2-DscHb1kZkQtC6kc8oDIcdSkxcC1RJFA9';

            //Google URL
            $url = 'https://fcm.googleapis.com/fcm/send';

            $headers = array(
                'Authorization: key=' . $fcmApiKey,
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

            // Execute post
            $result = curl_exec($ch);
            //echo '<pre>'; print_r($result);die;
            if ($result === false)
            {
                // return curl_error($ch);
                $result = curl_exec($ch);
                if ($result === false)
                {
                    return false;
                }
            }
            // Close connection
            curl_close($ch);

            return $result;
        }
    }
}
