<?php
/**
 * Created by PhpStorm.
 * User: mc
 * Date: 07/10/2016
 * Time: 15:51
 */

namespace Ecommerce\EcommerceBundle\Services;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class PanierManager
 * @package Ecommerce\EcommerceBundle\Services
 */
class PanierManager
{
    private $em;
    private $repository;
    private $tokenStrage;
    private $session;
    private $request;
    private $panier;
    private $produitsManager;
    
    
    /**
     * PanierManager constructor.
     * @param EntityManager $em
     * @param TokenStorage $tokenStorage
     * @param RequestStack $request
     * @param ProduitsManager $produitsManager
     */
    public function __construct(EntityManager $em,
                                TokenStorage $tokenStorage, 
                                RequestStack $request,
                                ProduitsManager $produitsManager)
    {
        $this->em              = $em;
        $this->repository      = $this->em->getRepository(
            'EcommerceBundle:Produits'
        );
        $this->tokenStrage     = $tokenStorage;
        $this->session         = new Session();
        $this->request         = $request->getMasterRequest();
        $this->produitsManager = $produitsManager;

    }
    
    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }
    
    public function getPanier()
    {
        if($this->session->has('panier')){
            $this->panier = $this->session->get('panier');
            return $this->session->get('panier');
        }else{

            return false;
        }

    }
    
    /**
     * @param $idProduit
     * @return mixed
     */
    public function addPanier($idProduit)
    {
        if (!$this->session->has('panier')) {
            $this->session->set('panier', []);
        }

        $this->panier = $this->getPanier();

        if (!empty($this->panier) && array_key_exists($idProduit, $this->panier)) {
            
            if ($this->request->query->get('qte') != null) {
                $this->panier [$idProduit] = (int) $this->request->query->get('qte');
                $this->session->getFlashBag()->add('success', 'Quantité modifié avec succés');
            }
            
        } else {
            
            if ($this->request->query->get('qte') != null) {
                $this->panier[$idProduit] = (int) $this->request->query->get('qte');
            } else {
                $this->panier[$idProduit] = 1;
            }
            
            $this->session->getFlashBag()->add('success', 'Article ajouter avec succés');
        }

        $this->session->set('panier', $this->panier);
    }
    
    /**
     * @param $idProduct
     */
    public function removeProductPanier($idProduct)
    {
       
        if (array_key_exists($idProduct, self::getPanier())) {
            unset($this->panier[$idProduct]);
            $this->session->set('panier', $this->panier);
            $this->session->getFlashBag()->add('success', 'Article supprimé avec succès');
        }
    }
    
    /**
     * @param array $arrayIdProducts
     * @return array
     */
    public function getProducts(array $arrayIdProducts)
    {
        return $this->produitsManager->getProductsByIdArray($arrayIdProducts);
    }

    public function countProductPanier()
    {
        return count($this->getPanier());
    }
    
}