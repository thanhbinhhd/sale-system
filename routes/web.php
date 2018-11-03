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
        Route::resource('admin-manager', 'AdminManageController')->middleware('admin.level');
        Route::group(['middleware' => 'admin.level', 'prefix' => 'admin-manager'], function(){
            Route::post('store', 'AdminManageController@store');
            Route::put('{$id}', 'AdminManageController@update');
            Route::delete('{$id}', 'AdminManageController@destroy'); 
        });
        Route::put('update-admin-status',['as' => 'update-admin-status', 'uses' => "AdminManageController@updateStatus"]);
        
        Route::get('dashboard',['as' => 'home', 'uses' => 'UserController@index']);
        Route::get('user-manager',['as' => 'user-manager', 'uses' => 'UserController@index']);
        Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
        Route::put('update-status',"UserController@updateStatus");
        //Route::resource('user-manager', 'UserController');
        
        Route::get('users/{id}',"UserController@detail");
    });
});
Route::group(['namespace' => 'User'], function() {
    Auth::routes(['verify' => true]);
});

Route::group(['namespace' => 'User', 'as' => 'user.'], function () {

    Route::group(['prefix' => 'user'], function () {
        Route::group(['namespace' => 'Auth', 'middleware' => 'guest'], function () {
            Route::get('login', ['as' => 'login', 'uses' => 'LoginController@showLoginForm']);
            Route::get('register', ['as' => 'register', 'uses' => 'RegisterController@showRegisterForm']);
            Route::post('register', ['as' => 'register', 'uses' => 'RegisterController@register']);
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
        Route::group(['middleware' => 'user_verified'], function () {

        });
        Route::get('/',['as' => 'home', function(){
            return view('user.home');
        }]);
        Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
    });
});
