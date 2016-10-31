<?php
/**
 * Created by PhpStorm.
 * User: mc
 * Date: 31/10/2016
 * Time: 12:42
 */

namespace Ecommerce\EcommerceBundle\Event;


use Symfony\Component\EventDispatcher\Event;

class PaysUpperCaseEvent extends Event
{
    
    const NEWADDR  = 'ecommerce.newadresse';
    const EDITADDR = 'ecommerce.editadresse';
    
    public function __construct()
    {
        
    }
    
}