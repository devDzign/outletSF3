<?php
/**
 * Created by PhpStorm.
 * User: mc
 * Date: 06/10/2016
 * Time: 16:48
 */

namespace Ecommerce\EcommerceBundle\Services;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class ProduitsManager
 *
 * @package Ecommerce\EcommerceBundle\Services
 */
class ProduitsManager
{
    private $em;
    private $repository;
    private $tokenStrage;
    private $session;
    
    /**
     * ProduitsManager constructor.
     *
     * @param EntityManager $em
     * @param TokenStorage $tokenStorage
     */
    public function __construct(EntityManager $em, TokenStorage $tokenStorage)
    {
        $this->em          = $em;
        $this->repository  = $this->em->getRepository(
            'EcommerceBundle:Produits'
        );
        $this->tokenStrage = $tokenStorage;
        $this->session     = new Session();
       
    }
    
    /**
     * @return array|\Ecommerce\EcommerceBundle\Entity\Produits[]
     */
    public function getAllProduct()
    {
        return $this->repository->findBy(['disponible'=>1]);
    }
    
    
    /**
     * @param $idProduit
     * @return \Ecommerce\EcommerceBundle\Entity\Produits
     */
    public function getOneProduct($idProduit)
    {
        return $this->repository->find($idProduit);
    }
    
    /**
     * @param $idCategorie
     * @return array
     */
    public function getProductByCategory($idCategorie)
    {
        return $this->repository->byCategorie($idCategorie);
    }
    
    /**
     * @param $str
     * @return array
     */
    public function searchProducts($str)
    {
        return $this->repository->searchProductsbyStr($str);
    }
    
    /**
     * @param $idProduct
     * @return array
     */
    public function removeProduct($idProduct)
    {
        return $this->repository->searchProductsbyStr($idProduct);
    }
    
    /**
     * @param $idProduit
     * @return array
     */
    public function addProduct($idProduit)
    {
        return $this->repository->searchProductsbyStr($idProduit);
    }
    
    /**
     * @param array $array
     * @return array
     */
    public function getProductsByIdArray(array  $array){
        
        return $this->repository->findArray($array);
    }

}