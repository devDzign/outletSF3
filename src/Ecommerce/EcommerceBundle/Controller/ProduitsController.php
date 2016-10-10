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
     *     "/produits",
     *      name="produits",
     *     )
     */
    public function produitsAction(Categories $idCategorie= null)
    {
        $panierManager = $this->get('panier_manager_service');
        $produitsManager      = $this->get('produits_manager_service');
       
        

        if(null != $idCategorie){
            
        }else{
            $produits      = $produitsManager->getAllProduct();
        }

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
    public function categorieProduitsAction($idCategorie)
    {
        $produits = $this->get('produits_manager_service')->getProductByCategory($idCategorie);

        return $this->render('@Ecommerce/Default/produits/layout/produits.html.twig', ['produits' => $produits]);
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
