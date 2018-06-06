<?php
/**
 * Created by PhpStorm.
 * User: UserCE
 * Date: 05.06.2018
 * Time: 16:53
 */

namespace Softce\Rangeofdishes\Http\Controllers;


use Illuminate\Http\Request;
use Mage2\Ecommerce\Http\Controllers\CartController;
use Illuminate\Support\Facades\Session;

class DishesController
{

    public function addToCartDishes(Request $request){

        Session::forget('cart');

        $packages = $request->get('package');
        //dump($packages);
        $products_slug = [];
        foreach($packages as $id => $package){
            foreach($package as $slug => $qty){

                if(!isset($products_slug[$slug])){
                    $products_slug[$slug] = (int)$qty;
                }
                else{
                    $products_slug[$slug] += $qty;
                }

            }
        }
        //dump($products_slug);

        if(count($products_slug)){
            $cart_controller = new CartController();
            foreach($products_slug as $slug => $qty){
                $request = new Request([
                    'slug' => $slug,
                    'qty' => $qty
                ]);
                //dump($request->get('slug').' -> '.$request->get('qty'));
                $cart_controller->addToCartProduct($request);
            }

            //dd(Session::get('cart'));
        }

        return redirect()->route('cart.view');
    }
}