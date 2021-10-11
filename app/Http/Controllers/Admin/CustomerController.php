<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\CustomersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\User;
use Validator, Str, DB, App, Session, Exception;

class CustomerController extends Controller
{
    public $views;
    public function __construct(){
        $this->views = 'admin/customers/';
    }
    /** 
     * manage customers view @get
     */ 
    public function index(Request $request){
        $page_name = 'customers';
        return view($this->views.'manage_customers',compact('page_name'));
    }

    /** 
     * customer listing view @get
     */ 
    public function list(Request $request, $type, $keyword=''){
    	$customers = User::customerListing($type,$keyword);
    	return view($this->views.'customer_list', compact('customers', 'keyword', 'type'));
    }
    
    /** 
     * customer listing export @get
     */ 
    public function export(Request $request, $type=1, $keyword=''){
    	$customers = User::customerListingExport($type,$keyword);
    	return Excel::download(new CustomersExport($customers), 'customers_'.date("Ymd_Hi").'.xlsx');
    }
}
