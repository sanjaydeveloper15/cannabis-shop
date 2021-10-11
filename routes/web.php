<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Default Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|----------------------------------
| Admin Routes
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. 
| @dev
| @laravel
| By: (@sanjaykumarwebs)
|----------------------------------
*/

Route::group(['middleware' => 'guest', 'namespace' => 'Admin'], function ()
{
	//----------------- GET Routes ------------------------------
	Route::get('admin', 'UserController@index')->name('admin');
	Route::get('admin/login', 'UserController@login')->name('admin/login');
	Route::get('user/login', 'Website\UserController@login')->name('user.login');
	Route::get('user/signup', 'Website\UserController@signup')->name('user.signup');
	Route::get('guest/verify_otp', 'Website\UserController@verify_otp')->name('guest.verify_otp');
	Route::get('user/forgot_password', 'Website\UserController@forgot_password')->name('user.forgot_password');
	Route::get('user/set_new_password', 'Website\UserController@set_new_password')->name('user.set_new_password');

	//--------------------- POST Routes ----------------------------------
	Route::post('admin/admin_login', 'UserController@admin_login')->name('admin.admin_login');
	Route::post('/admin/forgot_password_request', 'UserController@forgot_password_request')->name('admin.forgot_password_request');
	Route::post('/admin/set_new_password', 'UserController@set_new_password')->name('admin.set_new_password');
	Route::post('user/signup_request', 'Website\UserController@signup_request')->name('user.signup_request');
	Route::post('user/login_request', 'Website\UserController@login_request')->name('user.login_request');
	Route::post('/user/forgot_password_request', 'Website\UserController@forgot_password_request')->name('user.forgot_password_request');

	Route::post('user/guest_change_password_request', 'Website\UserController@guest_change_password_request')->name('user.guest_change_password_request');

});

Route::group(['middleware' => 'admin', 'namespace' => 'Admin'], function ()
{
	// ----------------------- GET Routes ---------------------------------
	Route::get('/admin/logout', 'UserController@logout')->name('admin/logout');

	Route::get('admin/categories', 'CategoryController@index')->name('admin/categories');
	Route::get('admin/categories/list/{type?}/{keyword?}', 'CategoryController@listing')->name('admin/categories/list');
	Route::get('admin/categories/change_status/{id?}', 'CategoryController@change_status')->name('admin/categories/change_status');

	Route::get('admin/device_types', 'DeviceTypeController@index')->name('admin/device_types');
	Route::get('admin/device_types/list/{type?}/{keyword?}', 'DeviceTypeController@listing')->name('admin/device_types/list');

	Route::get('admin/manage_brands', 'BrandController@index')->name('admin/manage_brands');
	Route::get('admin/brands/list/{type?}/{keyword?}', 'BrandController@listing')->name('admin/brands/list');

	Route::get('admin/strain_types', 'StrainTypeController@index')->name('admin/strain_types');
	Route::get('admin/strain_types/list/{type?}/{keyword?}', 'StrainTypeController@listing')->name('admin/strain_types/list');

	Route::get('admin/manage_products', 'ProductController@index')->name('admin/manage_products');
	Route::get('admin/products/{type?}/{id?}', 'ProductController@add_edit')->name('admin/products');
	Route::get('admin/product/listing/{type?}/{keyword?}/{from?}/{to?}/{cat?}', 'ProductController@listing')->name('admin/product/listing');
	Route::get('admin/product_details/{id?}', 'ProductController@details')->name('admin/product_details');

	Route::get('admin/manage_corresponding_products', 'CorrespondingProductController@index')->name('admin/manage_corresponding_products');
	Route::get('admin/corresponding_products/{type?}/{id?}', 'CorrespondingProductController@add_edit')->name('admin/corresponding_products');
	Route::get('admin/corresponding_product/listing/{type?}/{keyword?}/{from?}/{to?}/{cat?}', 'CorrespondingProductController@listing')->name('admin/corresponding_product/listing');

	Route::get('admin/manage_orders/{order_id?}/{notif_id?}', 'OrderController@index')->name('admin/manage_orders');
	Route::get('admin/order/listing/{status?}/{keyword?}', 'OrderController@listing')->name('admin/order/listing');
	Route::get('admin/order/details/{order_id?}', 'OrderController@details')->name('admin/order/details');
	Route::get('admin/order/change_status', 'OrderController@change_status')->name('admin/order/change_status');
	
	Route::get('admin/change_password', 'SettingController@change_password')->name('admin/change_password');

	Route::get('admin/manage_customers', 'CustomerController@index')->name('admin/manage_customers');
	Route::get('admin/customers/list/{type?}/{keyword?}', 'CustomerController@list')->name('admin/customers/list');
	Route::get('admin/customers/export/{type?}/{keyword?}', 'CustomerController@export')->name('admin/customers/export');

	Route::get('admin/manage_areas', 'AreasController@index')->name('admin/manage_areas');
	Route::get('admin/area_codes/list/{keyword?}', 'AreasController@listing')->name('admin/area_codes/list');

	Route::get('admin/manage_promotions', 'DiscountController@index')->name('admin/manage_promotions');
	Route::get('admin/manage_promotions/categories/{type?}/{keyword?}', 'DiscountController@categories_list')->name('admin/manage_promotions/categories');
	Route::get('admin/manage_promotions/products/{type?}/{keyword?}', 'DiscountController@products_list')->name('admin/manage_promotions/products');

	Route::get('admin/manage_banners', 'BannerController@index')->name('admin/manage_banners');
	Route::get('admin/manage_banners/list/{type?}', 'BannerController@list')->name('admin/manage_banners/list');

	Route::get('getRow', 'CommonController@getRow')->name('getRow');

	Route::get('admin/notif_count', 'UserController@notif_count')->name('admin.notif_count');
	Route::get('admin/popup_notif', 'UserController@popup_notif')->name('admin.popup_notif');
	Route::get('admin/notifications', 'UserController@notif_list')->name('admin.notifications');
	Route::get('admin/read_notif/{id?}', 'UserController@read_notif')->name('admin.read_notif');

	Route::get('admin/manage_inventory', 'InventoryController@index')->name('admin/manage_inventory');
	Route::get('admin/inventory/list/{type?}', 'InventoryController@listing')->name('admin/inventory/list');

	//--------------------- POST Routes ----------------------------------
	Route::post('admin/category_request', 'CategoryController@category_request')->name('admin.category_request');
	Route::post('admin/device_type_request', 'DeviceTypeController@device_type_request')->name('admin.device_type_request');
	Route::post('admin/brand_request', 'BrandController@brand_request')->name('admin.brand_request');
	Route::post('admin/strain_type_request', 'StrainTypeController@strain_type_request')->name('admin.strain_type_request');
	Route::post('admin/product_request', 'ProductController@product_request')->name('admin.product_request');
	Route::post('admin/corresponding_product_request', 'CorrespondingProductController@product_request')->name('admin.corresponding_product_request');
	Route::post('admin/area_code_request', 'AreasController@area_code_request')->name('admin.area_code_request');

	Route::post('admin/discount/save_cat', 'DiscountController@save_cat_discount')->name('admin/discount/save_cat');
	Route::post('admin/discount/save_product', 'DiscountController@save_product_discount')->name('admin/discount/save_product');

	Route::post('admin/banners/add_edit_request', 'BannerController@add_edit_request')->name('admin/banners/add_edit_request');

	Route::post('admin/change_password_request', 'SettingController@change_password_request')->name('admin/change_password_request');

	Route::post('deleteRow', 'CommonController@deleteRow')->name('deleteRow');
	Route::post('changeStatus', 'CommonController@changeStatus')->name('changeStatus');
	Route::post('makeNull', 'CommonController@makeNull')->name('makeNull');
});

Route::group(['middleware' => 'admin'], function ()
{
	//--------------------- GET Routes ----------------------------------
	Route::get('getRow', 'CommonController@getRow')->name('getRow');

	//--------------------- POST Routes ----------------------------------
	Route::post('deleteRow', 'CommonController@deleteRow')->name('deleteRow');
	Route::post('changeStatus', 'CommonController@changeStatus')->name('changeStatus');
	Route::post('makeNull', 'CommonController@makeNull')->name('makeNull');
});


//----------------- POST Routes ------------------------------
Route::post('user/deleteRow', 'CommonController@deleteRow')->name('user.deleteRow');

//--------------------- PUT Routes ----------------------------------
Route::put('user/save_token', 'CommonController@save_token')->name('user.save_token');


