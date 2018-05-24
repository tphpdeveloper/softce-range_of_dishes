<?php

namespace Softce\Rangeofdishes\Providers;

use Illuminate\Support\ServiceProvider;
use Softce\Rangeofdishes\FormOfDishes\BuildFormOfDishes;
use Softce\Rangeofdishes\FormOfDishes\Contract\FormOfDishes;

class RangeofdishesServiceProvider extends ServiceProvider
{

    public function boot(){

    }

    public function register(){
        $this->app->bind(FormOfDishes::class, function(){
            return new BuildFormOfDishes();
        });
    }

}