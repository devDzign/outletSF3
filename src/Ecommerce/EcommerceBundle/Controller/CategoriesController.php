<?php

namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class CategoriesController extends Controller
{

    /**
     * @Route(
     *     "/menu",
     *     name = "menu",
     * )
     */
    public function menuCateriesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('EcommerceBundle:Categories')->findAll();

        return $this->render('@Ecommerce/Default/categories/modulesUsed/menu.html.twig', ['categories' => $categories]);
    }
    
}
