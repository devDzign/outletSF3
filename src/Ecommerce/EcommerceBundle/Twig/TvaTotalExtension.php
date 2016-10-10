<?php
/**
 * Created by PhpStorm.
 * User: mc
 * Date: 07/10/2016
 * Time: 10:26
 */

namespace Ecommerce\EcommerceBundle\Twig;


class TvaTotalExtension extends \Twig_Extension
{


    public function getFilters()
    {
        return array(new \Twig_SimpleFilter('montantTva', [$this, 'montantTva']));
    }


    public function getName()
    {
        return 'TvaTotalExtensionFilter';
    }

    public function montantTva($prixHT, $tva)
    {
        $prixTVA = round((($prixHT /100) * $tva),2);

        return $prixTVA;
    }
}