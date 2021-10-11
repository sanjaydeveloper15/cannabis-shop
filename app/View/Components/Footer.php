<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\AreaZip;
class Footer extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $zip = AreaZip::firstZip();
        return view('components.footer',compact('zip'));
    }
}
