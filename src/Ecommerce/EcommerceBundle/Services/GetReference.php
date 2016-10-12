<?php
/**
 * Created by PhpStorm.
 * User: mc
 * Date: 10/10/2016
 * Time: 21:30
 */

namespace Ecommerce\EcommerceBundle\Services;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class GetReference
 * @package Ecommerce\EcommerceBundle\Services
 */
class GetReference
{
    
    private $em;
    private $tokenStorage;

    /**
     * GetReference constructor.
     * @param EntityManager $em
     * @param TokenStorage $tokenStorage
     */
    public function __construct(
        EntityManager $em,
        TokenStorage $tokenStorage
    )
    {
        $this->em           = $em;
        $this->tokenStorage = $tokenStorage;
    }
    
    /**
     * @return int
     */
    public function reference()
    {
        $reference = $this->em->getRepository('EcommerceBundle:Commandes')->findOneBy(array('valider' => 1), array('id' => 'DESC'),1,1);

        if (!$reference)
            return 1;
        else
            return $reference->getReference() +1;
    }

}