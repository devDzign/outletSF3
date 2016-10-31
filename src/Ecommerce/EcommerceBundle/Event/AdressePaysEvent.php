<?php
/**
 * Created by PhpStorm.
 * User: mc
 * Date: 31/10/2016
 * Time: 10:53
 */

namespace Ecommerce\EcommerceBundle\Event;


use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\User\UserInterface;

class AdressePaysEvent extends Event
{
    
    protected $pays;
    
    public function __construct($pays)
    {
        $this->pays = $this->setPays($pays);
    }
    
    // Le listener doit avoir accès au message
    public function getPays()
    {
        return ucfirst($this->pays);
    }
    
    // Le listener doit pouvoir modifier le message
    public function setPays($pays)
    {
        return $this->pays = ucfirst($pays);
    }
    
    
}