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

Route::group(['middleware' => 'auth:api'], function() {

    //---Block
    Route::get('/blog', 'EmployeeController\BlogController@getBlog');
    Route::post('/blog', 'EmployeeController\BlogController@createBlog');
    Route::get('/blog/{id}', 'EmployeeController\BlogController@getBlogByID');
    Route::delete('/blog/{id}', 'EmployeeController\BlogController@deleteBlogByID');

    //---Slide
    Route::get('/slide', 'EmployeeController\SlideController@getSlide');
    Route::post('/slide', 'EmployeeController\SlideController@createSlide')->middleware('scope:admin,employee');
    Route::get('/slide/{id}', 'EmployeeController\SlideController@getSlideByID');
    Route::delete('/slide/{id}', 'EmployeeController\SlideController@deleteSlideByID');

    //---Category 
    Route::get('/category', 'EmployeeController\CategoryController@getCategory');
    Route::post('/category', 'EmployeeController\CategoryController@createCategory');
    Route::get('/category/{id}', 'EmployeeController\CategoryController@getCategoryByID');
    Route::delete('/category/{id}', 'EmployeeController\CategoryController@deleteCategoryByID');

    //---Distributor 
    Route::get('/distributor', 'EmployeeController\DistributorController@getDistributor');
    Route::post('/distributor', 'EmployeeController\DistributorController@createDistributor');
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
    Route::get('/status', 'EmployeeController\StatusController@getStatus');
    Route::post('/status', 'EmployeeController\StatusController@createStatus');
    Route::get('/status/{id}', 'EmployeeController\StatusController@getStatusByID');
    Route::delete('/status/{id}', 'EmployeeController\StatusController@deleteStatusByID');

    //---Manufacturer 
    Route::get('/manufacturer', 'EmployeeController\ManufacturerController@getManufacturer')->middleware('scope:admin');
    Route::post('/manufacturer', 'EmployeeController\ManufacturerController@createManufacturer')->middleware('scope:admin');
    Route::get('/manufacturer/{id}', 'EmployeeController\ManufacturerController@getManufacturerByID')->middleware('scope:admin');
    Route::delete('/manufacturer/{id}', 'EmployeeController\ManufacturerController@deleteManufacturerByID')->middleware('scope:admin');

    //---Role 
    Route::get('/role', '_AuthController\RoleController@getRole')->middleware('scope:admin');
    Route::post('/role', '_AuthController\RoleController@createRole')->middleware('scope:admin');
    Route::delete('/role/{id}', '_AuthController\RoleController@deleteRoleByID')->middleware('scope:admin');
  

    //---Employee 
    Route::get('/employee', 'EmployeeController\EmployeeController@getEmployee')->middleware('scope:admin');
    Route::post('/register', '_AuthController\RegisterController@register')->middleware('scope:admin');
    Route::delete('/employee/{id}', 'EmployeeController\EmployeeController@deleteEmployeeByID')->middleware('scope:admin');
    Route::get('/employee/{id}', 'EmployeeController\EmployeeController@getEmployeeByID')->middleware('scope:admin');

    //---Logout
    Route::post('/logout', '_AuthController\LoginController@logout');
});

Route::post('/login', '_AuthController\LoginController@login');


