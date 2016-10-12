<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends Controller
{
    /**
     * @Route(
     *     "/factures",
     *      name = "factures"
     *     )
     */
    public function facturesAction()
    {
        $factures = $this->getDoctrine()->getRepository('EcommerceBundle:Commandes')->byFacture($this->getUser());

        return $this->render('UserBundle:Default/layout:facture.html.twig', array('factures' => $factures));
    }


    /**
     * @Route(
     *     "/factures/{id}",
     *      name = "facturesPDF"
     *     )
     */
    public function facturesPDFAction($id)
    {
        return $this->get('generate_facture_to_pdf_service')->generateFactureHtmlToPdf($id);
    }
}

