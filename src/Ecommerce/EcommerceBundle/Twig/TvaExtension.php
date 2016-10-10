<?php
/**
 * Created by PhpStorm.
 * User: mc
 * Date: 07/10/2016
 * Time: 10:26
 */

namespace Ecommerce\EcommerceBundle\Twig;


class TvaExtension extends \Twig_Extension
{


    public function getFilters()
    {
        return array(new \Twig_SimpleFilter('tva', [$this, 'calculeTva']));
    }


    public function getName()
    {
        return 'TvaExtensionFilter';
    }

    public function calculeTva($prixHT, $tva)
    {
        $prixTTC = round($prixHT * (1 + $tva / 100),2);

        return $prixTTC;
    }
}