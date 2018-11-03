<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use App\Http\Middleware\CheckAdminLevel;

Route::get('/', function () {
    return view('welcome');
});




Route::group(['namespace' => 'Admin', 'as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::group(['namespace' => 'Auth', 'middleware' => 'guest'], function () {
        Route::get('login', ['as' => 'login', 'uses' => 'LoginController@showLoginForm']);
        Route::post('login', ['as' => 'login', 'uses' => 'LoginController@authenticate']);
        Route::get('forgot-password', ['as' => 'forgot_password', 'uses' => 'ForgotPasswordController@showLinkRequestForm']);
        Route::post('email', ['as' => 'email', 'uses' => 'ForgotPasswordController@sendResetLinkEmail']);
        Route::get('get-reset/{token}', ['as' => 'get-reset', 'uses' => 'ResetPasswordController@showResetForm']);
        Route::post('reset', ['as' => 'reset', 'uses' => 'ResetPasswordController@reset']);
    });

    Route::group(['middleware' => 'admin'], function () {
        Route::group(['middleware' => 'admin.level', 'prefix' => 'AdminManager'], function(){
            Route::post('store', 'AdminManageController@store');
            Route::put('{$id}', 'AdminManageController@update');
            Route::delete('{$id}', 'AdminManageController@destroy'); 
        });
        Route::put('update-admin-status',"AdminManageController@updateStatus");
        
        Route::get('dashboard',['as' => 'home', 'uses' => 'UserController@index']);
        Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
        Route::put('update-status',"UserController@updateStatus");
        Route::resource('AdminManager', 'AdminManageController')->middleware(CheckAdminLevel::class);
        Route::resource('UsersManager', 'UserController');
        
    });
});

Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::group(['namespace' => 'Auth', 'middleware' => 'guest'], function () {
            Route::get('login', ['as' => 'login', 'uses' => 'LoginController@showLoginForm']);
            Route::post('login', ['as' => 'login', 'uses' => 'LoginController@authenticate']);
            Route::get('forgot-password', ['as' => 'forgot_password', 'uses' => 'ForgotPasswordController@showLinkRequestForm']);
            Route::post('email', ['as' => 'email', 'uses' => 'ForgotPasswordController@sendResetLinkEmail']);
            Route::get('get-reset/{token}', ['as' => 'get-reset', 'uses' => 'ResetPasswordController@showResetForm']);
            Route::post('reset', ['as' => 'reset', 'uses' => 'ResetPasswordController@reset']);
            Route::get('oauth/facebook/login', ['as' => 'oauth-facebook-login', 'uses' => 'OAuthController@redirectToProviderFacebook']);
            Route::get('oauth/facebook/callback', ['as' => 'oauth-facebook-callback', 'uses' => 'OAuthController@handleProviderCallbackFacebook']);
            Route::get('oauth/google/login', ['as' => 'oauth-google-login', 'uses' => 'OAuthController@redirectToProviderGoogle']);
            Route::get('oauth/google/callback', ['as' => 'oauth-google-callback', 'uses' => 'OAuthController@handleProviderCallbackGoogle']);
        });
    });

    Route::group(['middleware' => 'user'], function () {
        Route::get('/',['as' => 'home', function(){
            return view('user.home');
        }]);
        Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
    });
});
