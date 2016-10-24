<?php
/**
 * Created by PhpStorm.
 * User: mc
 * Date: 09/10/2016
 * Time: 01:17
 */

namespace Ecommerce\EcommerceBundle\Services;

use Doctrine\ORM\EntityManager;
use Ecommerce\EcommerceBundle\Entity\UtilisateursAdresses;
use Ecommerce\EcommerceBundle\Form\UtilisateursAdressesType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class UtilisateursAdressesHandler
{


    protected $form;
    protected $former;
    protected $request;
    protected $em;
    protected $security;
    protected $utilisateursAdresses;

    /**
     * UtilisateursAdressesHandler constructor.
     *
     * @param RequestStack $request
     * @param EntityManager $em
     * @param TokenStorage $security
     */
    public function __construct(
        FormFactory $form,
        RequestStack $request,
        EntityManager $em,
        TokenStorage $security,
        Form $former

    )
    {
        $this->request              = $request->getMasterRequest();
        $this->em                   = $em;
        $this->security             = $security;
        $this->utilisateursAdresses =  new UtilisateursAdresses();
        $this->form                 = $form->createBuilder(UtilisateursAdressesType::class,$this->utilisateursAdresses)->getForm();
        $this->former               = $former;

    }

    /**
     * @return bool
     */
    public function process()
    {
        $this->former->handleRequest($this->request);
    
        if ($this->request->isMethod('post') && $this->former->isValid()) {
            $this->onSuccess();

            return true;
        }

        return false;
    }

    /**
     *
     */
    protected function onSuccess()
    {
        $this->utilisateursAdresses = $this->former->getData();
        $this->utilisateursAdresses->setUtilisateur($this->security->getToken()->getUser());
        $this->em->persist($this->utilisateursAdresses);
        $this->em->flush();
    }
    
    /**
     * @return Form
     */
    public function getForm()
    {
        return $this->former;
    }

    /**
     * @return Former
     */
    public function getFormer()
    {
        return $this->former;
    }
    
    /**
     * @return UtilisateursAdresses
     *
     */
    public function getUtilisateursAdresses()
    {
        return $this->utilisateursAdresses;
    }

    /**
     * @return \Symfony\Component\Form\FormView
     */
    public function createForm()
    {
        return $this->former->createView();
    }
}