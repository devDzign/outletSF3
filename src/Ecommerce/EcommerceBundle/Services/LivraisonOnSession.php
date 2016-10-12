<?php
/**
 * Created by PhpStorm.
 * User: mc
 * Date: 10/10/2016
 * Time: 10:27
 */

namespace Ecommerce\EcommerceBundle\Services;


use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;


class LivraisonOnSession
{
    private $em;
    private $router;
    private $tokenStrage;
    private $session;
    private $request;
    
    
    /**
     * LivraisonOnSession constructor.
     * @param RequestStack $request
     * @param EntityManager $em
     * @param TokenStorage $tokenStorage
     * @param Router $router
     */
    public function __construct(RequestStack $request,
                                EntityManager $em,
                                TokenStorage $tokenStorage,
                                Router $router
    )
    {
        $this->em          = $em;
        $this->tokenStrage = $tokenStorage;
        $this->session     = new Session();
        $this->request     = $request->getMasterRequest();
        $this->router      = $router;
    }
    
    
    public function setLivraisonOnSession()
    {
    
    
        if (!$this->session->has('adresse')) $this->session->set('adresse', array());
        $adresse = $this->session->get('adresse');
    
        if ($this->request->request->get('livraison') != null && $this->request->request->get('facturation') != null) {
            $adresse['livraison']   = $this->request->request->get('livraison');
            $adresse['facturation'] = $this->request->request->get('facturation');
        } else {
            return new RedirectResponse($this->router->generate('validation'));
        }
    
        $this->session->set('adresse', $adresse);
        
        return new RedirectResponse($this->router->generate('validation'));
    }
}
