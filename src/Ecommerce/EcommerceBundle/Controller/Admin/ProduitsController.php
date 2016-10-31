<?php

namespace Ecommerce\EcommerceBundle\Controller\Admin;

use Ecommerce\EcommerceBundle\Entity\Produits;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Produit controller.
 * @Route("admin/produits")
 */
class ProduitsController extends Controller
{
    /**
     * Lists all produit entities.
     *
     * @Route("/", name="admin_produits_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $produits = $em->getRepository('EcommerceBundle:Produits')->findAll();
        
        return $this->render('EcommerceBundle:Admin/produits:index.html.twig', array(
            'produits' => $produits,
        ));
    }
    
    /**
     * Creates a new produit entity.
     *
     * @Route("/new", name="admin_produits_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $produit = new Produits();
        $form    = $this->createForm('Ecommerce\EcommerceBundle\Form\ProduitsType', $produit);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush($produit);
            
            return $this->redirectToRoute('admin_show', array('id' => $produit->getId()));
        }
        
        return $this->render('EcommerceBundle:Admin/produits:new.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Finds and displays a produit entity.
     *
     * @Route("/{id}", name="admin_produits_show")
     * @Method("GET")
     */
    public function showAction(Produits $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);
        
        return $this->render('EcommerceBundle:Admin/produits:show.html.twig', array(
            'entity' => $produit,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Creates a form to delete a produit entity.
     *
     * @param Produits $produit The produit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Produits $produit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_produits_delete', array('id' => $produit->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
    
    /**
     * Displays a form to edit an existing produit entity.
     *
     * @Route("/{id}/edit", name="admin_produits_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Produits $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);
        $editForm   = $this->createForm('Ecommerce\EcommerceBundle\Form\ProduitsType', $produit);
        $editForm->handleRequest($request);
        
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            return $this->redirectToRoute('admin_produits_edit', array('id' => $produit->getId()));
        }
        
        return $this->render('produits/edit.html.twig', array(
            'produit' => $produit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Deletes a produit entity.
     *
     * @Route("/{id}", name="admin_produits_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Produits $produit)
    {
        $form = $this->createDeleteForm($produit);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush($produit);
        }
        
        return $this->redirectToRoute('admin_produits_index');
    }
}
