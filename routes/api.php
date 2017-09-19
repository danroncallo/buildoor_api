<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Auth::routes();

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();

});




Route::get('users', 'UserController@index');
Route::get('uses/{use}', 'UseController@show');



/*ORDENADAS*/
Route::get('category/{category}/products', 'CategoryController@categoryProducts');
Route::get('categories', 'CategoryController@index');
Route::get('use/{use}/products', 'UseController@useProducts');
Route::post('send', 'EmailController@contactFormEmail');
Route::post('users/social', 'UserController@socialRegister');
Route::post('users', 'UserController@store');
Route::post('admin/login', 'AdminController@login');
Route::get('product/search/{keyword}', 'ProductController@searchKeyword');
Route::get('product/search/{min}/{max}', 'ProductController@searchByPriceRange');
Route::get('uses', 'UseController@index');
Route::get('products', 'ProductController@indexForStore');
Route::get('products/{product}', 'ProductController@show');

Route::group(['middleware' => ['auth:api', 'isUser']], function () {
    //USER CONTROLLER
    Route::get('users/token', 'UserController@getUserByToken');
    Route::put('users', 'UserController@update');
    Route::post('users/avatar', 'UserController@storeAvatar');
    Route::put('users/change/password', 'UserController@updatePassword');
    Route::put('users/change/visibility', 'UserController@updateVisibility');
});

Route::group(['middleware' => 'auth:api'], function () {
    //USER CONTROLLER
//    Route::resource('users', 'UserController', ['except' => ['index', 'store']]);

    Route::post('portfolio/{portfolio}/images', 'PortfolioController@storePortfoliosImages');
    Route::resource('portfolios', 'PortfolioController');

    Route::get('empty-cart', 'ShoppingCartController@emptyCart');
    Route::resource('cart', 'ShoppingCartController');
//    Route::resource('uses', 'UseController', ['except' => ['index', 'show']]);
    Route::post('place-order', 'OrderController@placeOrder');
    Route::get('orders/{id}', 'OrderController@orderDetails');
    Route::resource('orders', 'OrderController');
    
//    Route::get('portfolios', 'PortfolioController@index');
//    Route::post('portfolios', 'PortfolioController@store');
//    Route::put('portfolios', 'PortfolioController@update');
//    Route::delete('portfolios', 'PortfolioController@update');

});

Route::get('location/{location}/users', 'LocationController@locationUsers');
Route::get('country/{country}/states', 'CountryController@countryStates');

//Portfolios
//Route::post('cart/place_order', 'OrderController');

//Route::resource('orders', 'OrderController');
//Route::resource('products', 'ProductController');
//Route::resource('products', 'ProductController');




//Route::resource('categories', 'CategoryController');
Route::resource('locations', 'LocationController');
Route::resource('organizations', 'OrganizationController');
//Route::resource('stocks', 'StockController');
//Route::resource('users', 'UserController');
Route::resource('countries', 'CountryController');
//Route::resource('portfolios', 'PortfolioController');

Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');
//Route::get('place-order', 'OrderController@placeOrder');
Route::get('response', 'OrderController@response');

//Route::post('payu/confirmation', 'HomeController@confirmation');
Route::post('payu/confirmation', 'TransactionController@confirmation');


Route::get('test', 'TransactionController@updateOrder');

Route::group(['prefix' =>'admin', 'middleware' => ['auth:api', 'isAdmin']], function () {
    //PRODUCT CONTROLLER
    Route::put('products/status/{product}', 'ProductController@updateStatus');
    Route::get('products', 'ProductController@index');
    Route::post('products', 'ProductController@store');
    Route::post('product/{product}/images', 'ProductController@storeProductImages');
    Route::get('product/{product}/categories/uses', 'ProductController@productCategoriesAndUses');
    Route::get('products/{product}', 'ProductController@show');
    Route::put('products/{product}', 'ProductController@update');
    Route::delete('product/{image}/images', 'ProductController@deleteProductImages');

    //STOCK CONTROLLER
    Route::put('stocks/{stock}', 'StockController@update');

    //CATEGORY CONTROLLER
    Route::get('categories', 'CategoryController@index');
    Route::get('categories/{category}', 'CategoryController@show');
    Route::post('categories', 'CategoryController@store');
    Route::put('categories/{category}', 'CategoryController@update');
    Route::delete('categories/{category}', 'CategoryController@destroy');

    //USES CONTROLLER
    Route::get('uses', 'UseController@index');
    Route::get('uses/{use}', 'UseController@show');
    Route::post('uses', 'UseController@store');
    Route::put('uses/{use}', 'UseController@update');
    Route::delete('uses/{use}', 'UseController@destroy');
    
    //ADMIN CONTROLLER
    Route::get('profile', 'AdminController@profile');

});

