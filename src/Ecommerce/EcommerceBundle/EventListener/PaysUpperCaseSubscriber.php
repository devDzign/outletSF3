<?php
/**
 * Created by PhpStorm.
 * User: mc
 * Date: 31/10/2016
 * Time: 12:44
 */

namespace Ecommerce\EcommerceBundle\EventListener;


use Ecommerce\EcommerceBundle\Event\AdressePaysEvent;
use Ecommerce\EcommerceBundle\Event\PaysUpperCaseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PaysUpperCaseSubscriber implements EventSubscriberInterface
{
    
    public static function getSubscribedEvents()
    {
        
        return array(
            PaysUpperCaseEvent::NEWADDR => 'processPaysUC'
        );
        
    }
    
    public function processPaysUC(AdressePaysEvent $event)
    {
        
        dump('cool subscriber');
    }
}