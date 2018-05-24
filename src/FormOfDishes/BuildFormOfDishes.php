<?php
/**
 * Created by PhpStorm.
 * User: UserCE
 * Date: 24.05.2018
 * Time: 15:59
 */

namespace Softce\Rangeofdishes\FormOfDishes;

use Mage2\Ecommerce\Models\Database\Package;
use Softce\Rangeofdishes\FormOfDishes\Contract\FormOfDishes;

class BuildFormOfDishes implements FormOfDishes
{

    public function buildForm()
    {
        $packages = Package::with('products')->get();

        dump($packages);
    }
}

?>