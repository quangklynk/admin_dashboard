<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//---Block
Route::get('/blog', 'EmployeeController\BlogController@getBlog')->middleware('auth:api');
Route::post('/blog', 'EmployeeController\BlogController@createBlog')->middleware('auth:api');
Route::get('/blog/{id}', 'EmployeeController\BlogController@getBlogByID')->middleware('auth:api');
Route::delete('/blog/{id}', 'EmployeeController\BlogController@deleteBlogByID')->middleware('auth:api');

//---Slide
Route::get('/list-slide', 'EmployeeController\SlideController@getSlide');
Route::post('/list-slide', 'EmployeeController\SlideController@createSlide');
Route::get('/slide/{id}', 'EmployeeController\SlideController@getSlideByID');
Route::delete('/slide/{id}', 'EmployeeController\SlideController@deleteSlideByID');

//---Category 
Route::get('/list-category', 'EmployeeController\CategoryController@getCategory');
Route::post('/list-category', 'EmployeeController\CategoryController@createCategory');
Route::get('/category/{id}', 'EmployeeController\CategoryController@getCategoryByID');
Route::delete('/category/{id}', 'EmployeeController\CategoryController@deleteCategoryByID');

//---Distributor 
Route::get('/list-distributor', 'EmployeeController\DistributorController@getDistributor');
Route::post('/list-distributor', 'EmployeeController\DistributorController@createDistributor');
Route::get('/distributor/{id}', 'EmployeeController\DistributorController@getDistributorByID');
Route::delete('/distributor/{id}', 'EmployeeController\DistributorController@deleteBlogByID');

//---List_Image 
Route::get('/list_image', 'EmployeeController\List_ImageController@getList_Image');
Route::post('/list_image', 'EmployeeController\List_ImageController@createList_Image');
Route::get('/list_image/{id}', 'EmployeeController\List_ImageController@getList_ImageByID');
Route::delete('/list_image/{id}', 'EmployeeController\List_ImageController@deleteList_ImageByID');

//---Product 
Route::get('/list-product', 'EmployeeController\ProductController@getProduct');
Route::post('/list-product', 'EmployeeController\ProductController@createProduct');
Route::get('/product/{id}', 'EmployeeController\ProductController@getProductByID');
Route::delete('/product/{id}', 'EmployeeController\ProductController@deleteBlogByID');

//---Status 
Route::get('/list-status', 'EmployeeController\StatusController@getStatus');
Route::post('/list-status', 'EmployeeController\StatusController@createStatus');
Route::get('/status/{id}', 'EmployeeController\StatusController@getStatusByID');
Route::delete('/status/{id}', 'EmployeeController\StatusController@deleteStatusByID');

//---Manufacturer 
Route::get('/manufacturer', 'EmployeeController\Manufacturer@getManufacturer');
Route::post('/manufacturer', 'EmployeeController\Manufacturer@createManufacturer');
Route::get('/manufacturer/{id}', 'EmployeeController\Manufacturer@getManufacturerByID');
Route::delete('/manufacturer/{id}', 'EmployeeController\Manufacturer@deleteManufacturerByID');

Route::post('/register', '_AuthController\RegisterController@register');
Route::post('/login', '_AuthController\LoginController@login');

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
