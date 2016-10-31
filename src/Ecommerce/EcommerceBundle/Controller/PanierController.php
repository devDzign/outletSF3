<?php

namespace Ecommerce\EcommerceBundle\Controller;


use Ecommerce\EcommerceBundle\Entity\Commandes;
use Ecommerce\EcommerceBundle\Event\AdressePaysEvent;
use Ecommerce\EcommerceBundle\Event\EcommerceEvents;
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
    public function livraisonAction(Request $request)
    {
        $handler = $this->get("utilisateurs_adresses_handler");

        if ($handler->process()) {
            return $this->redirectToRoute('livraison');
        }
        
        return $this->render('EcommerceBundle:Default:panier/layout/livraison.html.twig',
            [
                'form' => $handler->createForm(),
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

        $repository      = $this->getDoctrine();
        $em              = $repository->getManager();
        $prepareCommande = $this->forward('EcommerceBundle:Commandes:prepareCommande');
        $commande        = $em->getRepository('EcommerceBundle:Commandes')->find($prepareCommande->getContent());
    
        return $this->render('EcommerceBundle:Default:panier/layout/validation.html.twig', array('commande' => $commande));
    }
    
    
    /**
     * @Route(
     *     "/tester",
     *     name = "testerGuzzle"
     *     )
     */
    
    public function testAction()
    {
        $client  = $this->get('guzzle.client');
        $test    = $client->get("https://www.google.fr/search?q=google");
        $request = $client->createRequest('GET', 'https://www.google.fr/search', null, ['q' => "bob marley"]);
        $test3   = $request->send();
        $test2   = $test->send();
        // dump($test);
        dump($request);
        dump($test3->getBody());
        //dump($test2->getBody(true));
        exit("tetetet");
    }
    
    
}
