<?php

namespace Ecommerce\EcommerceBundle\Controller\Admin;

use Ecommerce\EcommerceBundle\Entity\Tva;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tva controller.
 *
 * @Route("admin")
 */
class AdminController extends Controller
{
    /**
     * Lists all tva entities.
     *
     * @Route("/", name="admin_home_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        
        return $this->render('@Ecommerce/Admin/index.html.twig', array());
    }
    
    
}
