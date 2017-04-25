<?php
/**
 * Created by PhpStorm.
 * User: mc
 * Date: 08/10/2016
 * Time: 23:38
 */

namespace Ecommerce\EcommerceBundle\EventListener;


use Ecommerce\EcommerceBundle\Services\PanierManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class RedirectionListener
 * @package Ecommerce\EcommerceBundle\EventListener
 */
class RedirectionListener
{
    protected $token;
    protected $router;
    protected $panierManager;
    
    /**
     * RedirectionListener constructor.
     * @param TokenStorage $tokenStorage
     * @param Router $router
     * @param PanierManager $panierManager
     */
    public function __construct(TokenStorage $tokenStorage, Router $router, PanierManager $panierManager)
    {
        $this->token         = $tokenStorage;
        $this->router        = $router;
        $this->panierManager = $panierManager;
    }
    
    public function onKernelRequest(GetResponseEvent $event)
    {
        $route = $event->getRequest()->attributes->get('_route');
        
        if ($route == 'livraison' || $route == 'validation') {
            if ($this->panierManager->getSession()->has('panier')) {

                if ($this->panierManager->countProductPanier() === 0) {
                    $event->setResponse(new RedirectResponse($this->router->generate('panier')));
                }

            }
            
            if (!is_object($this->token->getToken()->getUser())) {
                $this->panierManager->getSession()->getFlashBag()->add('notification', 'Vous devez vous identifier');
                $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login')));
            }
        }
    }
    
}