<?php
/**
 * Created by PhpStorm.
 * User: mc
 * Date: 31/10/2016
 * Time: 10:49
 */

namespace Ecommerce\EcommerceBundle\Event;


/**
 * Cette classe ne fait donc rien, elle ne sert qu'à faire la correspondance entre ADREESSE_PAYS
 * qu'on utilisera pour déclencher l'évènement et le nom de l'évènement en lui même ecommerce_events.adresse_pays.
 * Class EcommerceEvents
 * @package Ecommerce\EcommerceBundle\Event
 */
final class EcommerceEvents
{
    const ADREESSE_PAYS = 'ecommerce_events.adresse_pays';
}