<?php

namespace UserBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;


/**
 * User controller.
 *
 * @Route("admin/users")
 */
class UserController extends Controller
{
    /**
     * @Route(
     *     "/",
     *      name = "admin_user_index",
     *     )
     */
    public function indexAction()
    {
        $em    = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        
        return $this->render('@User/Admin/user/index.html.twig', array('users' => $users));
    }
    
    
    /**
     *
     *
     * @Route(
     *     "/{id}/adresses",
     *      name = "admin_adresses_user",
     *     )
     * @Route(
     *     "/{id}/factures",
     *      name = "admin_factures_user",
     *     )
     *
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function utilisateurAction($id, Request $request)
    {
        $em    = $this->getDoctrine()->getManager();
        $user  = $em->getRepository('UserBundle:User')->find($id);
        $route = $request->get('_route');
        
        if ($route == 'admin_adresses_user')
            return $this->render('@User/Admin/user/adresses.html.twig', array('user' => $user));
        else if ($route == 'admin_factures_user')
            return $this->render('@User/Admin/user/facture.html.twig', array('user' => $user));
        else
            throw $this->createNotFoundException('La vue n\'existe pas.');
    }
    
    
}

