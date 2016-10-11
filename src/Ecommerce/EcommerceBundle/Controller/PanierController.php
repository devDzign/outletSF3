<?php

namespace Ecommerce\EcommerceBundle\Controller;


use Ecommerce\EcommerceBundle\Form\UtilisateursAdressesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


/**
 * @Route("/panier",
 *     )
 */
class PanierController extends Controller
{
    /**
     * @Route(
     *     "/produit/ajouter/{idProduit}",
     *      name = "ajouter"
     *     )
     */
    public function ajouterAction($idProduit)
    {
        $panierManager = $this->get('panier_manager_service');
        $panierManager->addPanier($idProduit);
        
        return $this->redirectToRoute('panier');
    }
    
    /**
     * @Route(
     *     "/menu",
     *     name = "panierMenu"
     *     )
     */
    public function menuAction()
    {
        $panierManger = $this->get('panier_manager_service');
        $nbArticles   = $panierManger->countProductPanier();
        
        return $this->render('@Ecommerce/Default/panier/moduleUsed/menu.html.twig', ['nbArticles' => $nbArticles]);
        
    }
    
    /**
     * @Route(
     *     "/produit/supprimer/{idProduit}",
     *      name = "supprimer"
     *     )
     */
    public function supprimerAction($idProduit)
    {
        $panier = $this->get('panier_manager_service');
        $panier->removeProductPanier($idProduit);
        
        return $this->redirectToRoute('panier');
    }
    
    
    /**
     * @Route(
     *     "/",
     *      name = "panier"
     *     )
     */
    public function panierAction()
    {
        $panierService = $this->get('panier_manager_service');
        $session       = $panierService->getSession();
        
        if (!$session->has('panier')) {
            $session->set('panier', []);
        }
        
        $panier = $panierService->getPanier();
        
        if (empty($panier)) {
            $produits = [];
        } else {
            $produits = $panierService->getProducts(array_keys($panier));
        }
        
        
        return $this->render('EcommerceBundle:Default:panier/layout/panier.html.twig', ['produits' => $produits, 'panier' => $panier]);
    }
    
    /**
     * @Route(
     *     "/livraison",
     *      name = "livraison"
     *     )
     */
    public function livraisonAction()
    {
        $handler = $this->get("utilisateurs_adresses_handler");
        $form    = $handler->getForm();
        
        if ($handler->process()) {
            return $this->redirectToRoute('livraison');
        }
        
        return $this->render('EcommerceBundle:Default:panier/layout/livraison.html.twig',
            [
                'form' => $form->createView(),
                'utilisateur' => $this->getUser()
            ]
        );
    }
    
    /**
     * @Route(
     *     "/livraison/remove/adresse/{id}",
     *     name = "livraisonAdresseSuppression"
     *     )
     */
    public function adresseSuppressionAction($id)
    {
        $em     = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EcommerceBundle:UtilisateursAdresses')->find($id);
        
        if ($this->getUser() != $entity->getUtilisateur() || !$entity) {
            return $this->redirect($this->generateUrl('livraison'));
        }
        
        $em->remove($entity);
        $em->flush();
        
        return $this->redirectToRoute('livraison');
    }
    
    
    /**
     * @Route(
     *     "/validation",
     *     name = "validation"
     *     )
     */
    public function validationAction(Request $request)
    {

        $serviceSession = $this->get('utilisateurs_session_livraison_service');
        if ($request->getMethod() == 'POST') {
            $serviceSession->setLivraisonOnSession();
        }
        
        $em      = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $adresse = $session->get('adresse');
        
        $produits    = $em->getRepository('EcommerceBundle:Produits')->findArray(array_keys($session->get('panier')));
        $livraison   = $em->getRepository('EcommerceBundle:UtilisateursAdresses')->find($adresse['livraison']);
        $facturation = $em->getRepository('EcommerceBundle:UtilisateursAdresses')->find($adresse['facturation']);
    
        return $this->render('EcommerceBundle:Default:panier/layout/validation.html.twig', array(
                'produits' => $produits,
                'livraison' => $livraison,
                'facturation' => $facturation,
                'panier' => $session->get('panier')
            )
        );
    }
    
    
}
