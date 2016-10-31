<?php
/**
 * Created by PhpStorm.
 * User: mc
 * Date: 31/10/2016
 * Time: 11:29
 */

namespace Ecommerce\EcommerceBundle\EventListener;


use Symfony\Component\HttpFoundation\RequestStack;

class UcAdressePaysListener
{
    
    protected $request;
    
    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getMasterRequest();
    }
    
    public function processMessage()
    {
//        dump($this->request);
//        die('event listner');
    }
}