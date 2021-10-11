<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use App\Product;
use App\GuestCart;
use App\Cart;
use App\AreaZip;

class Header extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $title;
    public function __construct($data)
    {
        $this->title = $data;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {   
        $categories = Product::productCategories();
        if(isCustomerLogin()){
            $my_cart_count =Cart::myCartCount(Auth::user()->id);
        }else{
            $my_cart_count =GuestCart::myCartCount(userGuestId());    
        }
        // $area_zip = AreaZip::first();
        // $zip = ($area_zip) ? $area_zip->area_code : '_ _ _ _ _' ;
        $zip = AreaZip::firstZip();
        return view('components.header',compact('categories','my_cart_count','zip'));
    }
}
