<?php

namespace Ecommerce\EcommerceBundle\Controller\Admin;

use Ecommerce\EcommerceBundle\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Category controller.
 *
 * @Route("admin/categories")
 */
class CategoriesController extends Controller
{
    /**
     * Lists all category entities.
     *
     * @Route("/", name="admin_categories_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $categories = $em->getRepository('EcommerceBundle:Categories')->findAll();
        
        return $this->render('EcommerceBundle:Admin/categories:index.html.twig', array(
            'categories' => $categories,
        ));
    }
    
    /**
     * Creates a new category entity.
     *
     * @Route("/new", name="admin_categories_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $category = new Categories();
        $form     = $this->createForm('Ecommerce\EcommerceBundle\Form\CategoriesType', $category);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush($category);
            $this->addFlash('success', 'category.new_successfully');
            
            return $this->redirectToRoute('admin_categories_show', array('id' => $category->getId()));
        }
        
        return $this->render('EcommerceBundle:Admin/categories:new.html.twig', array(
            'category' => $category,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Finds and displays a category entity.
     *
     * @Route("/{id}", name="admin_categories_show")
     * @Method("GET")
     */
    public function showAction(Categories $category)
    {
        $deleteForm = $this->createDeleteForm($category);
        
        return $this->render('EcommerceBundle:Admin/categories:show.html.twig', array(
            'entity' => $category,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Creates a form to delete a category entity.
     *
     * @param Categories $category The category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Categories $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_categories_delete', array('id' => $category->getId())))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, ['label' => 'Delete'])
            ->getForm();;
    }
    
    /**
     * Displays a form to edit an existing category entity.
     *
     * @Route("/{id}/edit", name="admin_categories_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Categories $category)
    {
        $deleteForm = $this->createDeleteForm($category);
        $editForm   = $this->createForm('Ecommerce\EcommerceBundle\Form\CategoriesType', $category);
        $editForm->handleRequest($request);
        
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'category.edit_successfully');
            
            return $this->redirectToRoute('admin_categories_edit', array('id' => $category->getId()));
        }
        
        return $this->render('EcommerceBundle:Admin/categories:edit.html.twig', array(
            'category' => $category,
            'form_edit' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Deletes a category entity.
     *
     * @Route("/{id}", name="admin_categories_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Categories $category)
    {
        $form = $this->createDeleteForm($category);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush($category);
            $this->addFlash('success', 'category.delete_successfully');
        }
        
        return $this->redirectToRoute('admin_categories_index');
    }
}
