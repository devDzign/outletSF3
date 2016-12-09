<?php

namespace Ecommerce\EcommerceBundle\Controller\Admin;


use Ecommerce\EcommerceBundle\Entity\Commandes;
use Ecommerce\EcommerceBundle\Form\UtilisateursAdressesType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Category controller.
 *
 * @Route("admin/commandes")
 */
class CommandesController extends Controller
{
    
    /**
     * Lists all Cammandes entities.
     *
     * @Route("/", name="admin_commandes_index")
     * @Method("GET")
     */
    public function commandesAction()
    {
        $em        = $this->getDoctrine()->getManager();
        $commandes = $em->getRepository('EcommerceBundle:Commandes')->findAll();
        
        return $this->render('@Ecommerce/Admin/commandes/index.html.twig', array('commandes' => $commandes));
    }
    
    /**
     * Finds and displays a category entity.
     *
     * @Route("/facture/{id}", name="admin_commandes_show")
     * @Method("GET")
     */
    public function showFactureAction(Commandes $commandes)
    {
        $em      = $this->getDoctrine()->getManager();
        $facture = $em->getRepository('EcommerceBundle:Commandes')->find($commandes->getId());
    
        if (!$facture) {
            $this->addFlash('error', 'Une erreur est survenue pdf');
            
            return $this->redirectToRoute('admin_commandes_index');
        }
    
        return $this->get('generate_facture_to_pdf_service')->generateFactureHtmlToPdf($facture->getId(), 'admin_commandes_index');
        
    }
}
