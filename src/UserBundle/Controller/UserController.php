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
    public function facturesPDFAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $facture = $em->getRepository('EcommerceBundle:Commandes')->findOneBy(array('utilisateur' => $this->getUser(),
                                                                                    'valider' => 1,
                                                                                    'id' => $id));
        $session = new Session();

        if (!$facture) {
            $session->getFlashBag()->add('error', 'Une erreur est survenue');
            return $this->redirectToRoute('factures');
        }

        
        $html = $this->renderView('UserBundle:Default:layout/facturePDF.html.twig', array('facture' => $facture));

        $html2pdf = $this->get('html2pdf_factory')->create();
        
        $html2pdf->pdf->SetAuthor('DevAndClick');
        $html2pdf->pdf->SetTitle('Facture '.$facture->getReference());
        $html2pdf->pdf->SetSubject('Facture DevAndClick');
        $html2pdf->pdf->SetKeywords('facture,devandclick');
        $html2pdf->pdf->SetDisplayMode('real');
        $html2pdf->writeHTML($html);
        $html2pdf->Output('Facture.pdf');

        $response = new Response();
        $response->headers->set('Content-type' , 'application/pdf');

        return $response;
    }

}
