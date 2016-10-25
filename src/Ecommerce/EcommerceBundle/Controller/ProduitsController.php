<?php

namespace Ecommerce\EcommerceBundle\Controller;

use Ecommerce\EcommerceBundle\Entity\Categories;
use Ecommerce\EcommerceBundle\Entity\Produits;
use Ecommerce\EcommerceBundle\Form\RechercheType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


class ProduitsController extends Controller
{
    /**
     * @Route(
     *     "/",
     *      name="produits",
     *     )
     */
    public function produitsAction(Request $request, Categories $idCategorie = null)
    {
        $panierManager   = $this->get('panier_manager_service');
        $produitsManager = $this->get('produits_manager_service');
    
        if (null != $idCategorie) {
            $produits = $produitsManager->getProductByCategory($idCategorie);
        } else {
            $produits = $produitsManager->getAllProduct();
        }
    
        $paginator = $this->get('knp_paginator');
        $produits  = $paginator->paginate(
            $produits, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $this->getParameter('knp_paginator.page_range')/*limit per page*/
        );

        return $this->render('EcommerceBundle:Default:produits/layout/produits.html.twig',
            [
                'produits' => $produits,
                'panier' => $panierManager->getPanier()
            ]
        );
    }


    /**
     * @Route(
     *     "/categorie/{idCategorie}",
     *     name = "categorieProduits",
     * )
     */
    public function categorieProduitsAction(Request $request, $idCategorie)
    {
        return $this->redirectToRoute('produits', array('idCategorie' => $idCategorie));
    }


    /**
     * @Route(
     *     "/presentation/{idProduit}",
     *      name="presentation"
     *     )
     */
    public function presentationAction($idProduit)
    {
        $produit       = $this->get('produits_manager_service')->getOneProduct($idProduit);
        $panierManager = $this->get('panier_manager_service');

        if (!$produit) throw $this->createNotFoundException('La page n\'existe pas.');

        return $this->render('EcommerceBundle:Default:produits/layout/presentation.html.twig',
            [
                'produit' => $produit,
                'panier' => $panierManager->getPanier()
            ]
        );
    }


    /**
     * @Route(
     *     "/produits/menuRecherche",
     *      name="menuRecherche"
     *     )
     */
    public function rechercheAction()
    {
        $form = $this->createForm(RechercheType::class);

        return $this->render('EcommerceBundle:Default:Recherche/modulesUsed/recherche.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route(
     *     "/produits/recherche",
     *      name="recherche"
     *     )
     */
    public function rechercheTraitementAction(Request $request)
    {
        $form = $this->createForm(RechercheType::class);
        $form->handleRequest($request);
        $produits = null;
        if ($request->getMethod() == 'POST') {
            $str      = $request->request->get("recherche")['motCle'];
            $produits = $this->get('produits_manager_service')->searchProducts($str);
        }

        return $this->render('@Ecommerce/Default/produits/layout/produits.html.twig', array('produits' => $produits));
    }
}
