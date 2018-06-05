<?php
/**
 * Created by PhpStorm.
 * User: UserCE
 * Date: 24.05.2018
 * Time: 15:59
 */

namespace Softce\Rangeofdishes\FormOfDishes;

use Mage2\Ecommerce\Models\Database\LangStatic;
use Mage2\Ecommerce\Models\Database\Package;
use Softce\Rangeofdishes\FormOfDishes\Contract\FormOfDishes;

class BuildFormOfDishes implements FormOfDishes
{

    public function buildForm()
    {
        $packages = Package::with([
            'products',
            'products.variants',
            'products.variants.attributeValue',
            'products.variants.attributeValue.attribute',
            'products.attributeValue',
            'products.attributeValue.attribute'
        ])->get();

        $attributes = $packages->first()->products->first()->categories->first()->attribute;

        $all_dishes = '';
        $single_dishes = '';
        if ($packages) {
            $lang_static = new LangStatic();
            $choose = $lang_static->getTranslate('choose');
            $what = [
                '',
                $lang_static->getTranslate('dinner'),
                $lang_static->getTranslate('dinner-2'),
                $lang_static->getTranslate('buy'),
            ];

            foreach ($packages as $co_package => $package) {

                $data = [
                    'attributes' => $attributes,
                    'package' => $package,
                    'name_button' => (($co_package + 1) != count($packages) ? $choose . ' ' . $what[($co_package + 1)] : $what[($co_package + 1)])
                ];


                if (!$co_package) {
                    $data['active'] = true;
                }

                if($co_package + 1 == count($packages)){
                    $data['button_type'] = true;
                }
                $all_dishes .= view('dishes::structure-dishes', $data)->render() ;

                $data['single_dishes'] = true;
                $data['name_button'] = $what[count($what) - 1];
                $single_dishes .= view('dishes::structure-dishes', $data)->render();

            }
        }


        return view('dishes::view-of-dishes')
            ->with('packages', $packages)
            ->with('all_dishes', $all_dishes)
            ->with('single_dishes', $single_dishes);
    }

}

?>