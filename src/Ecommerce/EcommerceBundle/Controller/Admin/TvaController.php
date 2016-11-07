<?php

namespace Ecommerce\EcommerceBundle\Controller\Admin;

use Ecommerce\EcommerceBundle\Entity\Tva;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tva controller.
 *
 * @Route("admin/tva")
 */
class TvaController extends Controller
{
    /**
     * Lists all tva entities.
     *
     * @Route("/", name="admin_tva_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $tvas = $em->getRepository('EcommerceBundle:Tva')->findAll();
        
        return $this->render('@Ecommerce/Admin/tva/index.html.twig', array(
            'tvas' => $tvas,
        ));
    }
    
    /**
     * Creates a new tva entity.
     *
     * @Route("/new", name="admin_tva_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tva  = new Tva();
        $form = $this->createForm('Ecommerce\EcommerceBundle\Form\TvaType', $tva);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tva);
            $em->flush($tva);
            
            return $this->redirectToRoute('admin_tva_show', array('id' => $tva->getId()));
        }
        
        return $this->render('tva/new.html.twig', array(
            'tva' => $tva,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Finds and displays a tva entity.
     *
     * @Route("/{id}", name="admin_tva_show")
     * @Method("GET")
     */
    public function showAction(Tva $tva)
    {
        $deleteForm = $this->createDeleteForm($tva);
        
        return $this->render('@Ecommerce/Admin/tva/show.html.twig', array(
            'tva' => $tva,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Creates a form to delete a tva entity.
     *
     * @param Tva $tva The tva entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tva $tva)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tva_delete', array('id' => $tva->getId())))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, ['label' => 'Delete'])
            ->getForm();;
    }
    
    /**
     * Displays a form to edit an existing tva entity.
     *
     * @Route("/{id}/edit", name="admin_tva_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tva $tva)
    {
        $deleteForm = $this->createDeleteForm($tva);
        $editForm   = $this->createForm('Ecommerce\EcommerceBundle\Form\TvaType', $tva);
        $editForm->handleRequest($request);
        
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            return $this->redirectToRoute('admin_tva_edit', array('id' => $tva->getId()));
        }
        
        return $this->render('@Ecommerce/Admin/tva/edit.html.twig', array(
            'tva' => $tva,
            'form_edit' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Deletes a tva entity.
     *
     * @Route("/{id}", name="admin_tva_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tva $tva)
    {
        $form = $this->createDeleteForm($tva);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tva);
            $em->flush($tva);
        }
        
        return $this->redirectToRoute('admin_tva_index');
    }
}
