<?php

namespace Ecommerce\EcommerceBundle\Controller;


use Ecommerce\EcommerceBundle\Entity\Commandes;
use Ecommerce\EcommerceBundle\Form\UtilisateursAdressesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;


class CommandesController extends Controller
{
    /**
     * @Route(
     *     "/commandes",
     *      name = "commandes"
     *     )
     */
    public function prepareCommandeAction(Request $request)
    {
        $session = $request->getSession();
        $em      = $this->getDoctrine()->getManager();
        
        if (!$session->has('commande'))
            $commande = new Commandes();
        else
            $commande = $em->getRepository('EcommerceBundle:Commandes')->find($session->get('commande'));
        
        $commande->setDate(new \DateTime());
        $commande->setUtilisateur($this->getUser());
        $commande->setValider(0);
        $commande->setReference(0);
        $commande->setCommande($this->get('facture_manager_service')->facture());
        
        if (!$session->has('commande')) {
            $em->persist($commande);
            $session->set('commande', $commande);
        }
        
        $em->flush();
        
        return new Response($commande->getId());
    }
    
    
    /**
     * Cette methode remplace l'api banque.
     * @Route(
     *     "/commandes/valider/{id}",
     *      name = "validationCommande"
     *     )
     */
    public function validationCommandeAction(Request $request, $id)
    {
        $em       = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('EcommerceBundle:Commandes')->find($id);
        
        if (!$commande || $commande->getValider() == 1)
            throw $this->createNotFoundException('La commande n\'existe pas');
        
        $commande->setValider(1);
        $commande->setReference($this->get('get_reference_facture_service')->reference());
        $em->flush();
        
        $session = $request->getSession();
        $session->remove('adresse');
        $session->remove('panier');
        $session->remove('commande');
    
    
        // envoie de mail de confirmation
        $commande = $em->getRepository('EcommerceBundle:Commandes')->find($id);
        $mail     = $this->get('send.mail.service');
        $mail->commandeConfirm($commande);;
        $session->getFlashBag()->add('success', 'Votre commande est validé avec succès');
        
        return $this->redirectToRoute('produits');
    }
    
}
