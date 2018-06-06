<?php


Route::group([
    'namespace' => 'Softce\Rangeofdishes\Http\Controllers',
    'middleware' => ['web']
],function(){

    Route::post( '/add/dishes', ['as' => 'add.dishes', 'uses' => 'DishesController@addToCartDishes' ] );

});