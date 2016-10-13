<?php

namespace Pages\PagesBundle\Controller\Admin;

use Pages\PagesBundle\Entity\Pages;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Page controller.
 *
 * @Route("admin/pages")
 */
class PagesController extends Controller
{
    /**
     * Lists all page entities.
     *
     * @Route("/", name="admin_pages_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pages = $em->getRepository('PagesBundle:Pages')->findAll();

        return $this->render('@Pages/Admin/pages/index.html.twig', array(
            'pages' => $pages,
        ));
    }

    /**
     * Creates a new page entity.
     *
     * @Route("/new", name="admin_pages_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $page = new Page();
        $form = $this->createForm('Pages\PagesBundle\Form\PagesType', $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush($page);

            return $this->redirectToRoute('admin_pages_show', array('id' => $page->getId()));
        }

        return $this->render('@Pages/Admin/pages/new.html.twig', array(
            'page' => $page,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a page entity.
     *
     * @Route("/{id}", name="admin_pages_show")
     * @Method("GET")
     */
    public function showAction(Pages $page)
    {
        $deleteForm = $this->createDeleteForm($page);

        return $this->render('@Pages/Admin/pages/show.html.twig', array(
            'page' => $page,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing page entity.
     *
     * @Route("/{id}/edit", name="admin_pages_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Pages $page)
    {
        if (!$page) {
            throw $this->createNotFoundException('Unable to find Pages entity.');
        }
        $deleteForm = $this->createDeleteForm($page);
        $editForm   = $this->createForm('Pages\PagesBundle\Form\PagesType', $page);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_pages_edit', array('id' => $page->getId()));
        }

        return $this->render('PagesBundle:Admin/pages:edit.html.twig', array(
            'page' => $page,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a page entity.
     *
     * @Route("/{id}", name="admin_pages_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Pages $page)
    {
        $form = $this->createDeleteForm($page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if (!$page) {
                throw $this->createNotFoundException('Unable to find Pages entity.');
            }

            $em->remove($page);
            $em->flush($page);
        }

        return $this->redirectToRoute('admin_pages_index');
    }

    /**
     * Creates a form to delete a page entity.
     *
     * @param Pages $page The page entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pages $page)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_pages_delete', array('id' => $page->getId())))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, ['label' => 'Delete'])
            ->getForm();
    }
    
    public function updateAction(Request $request, Pages $page)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('PagesBundle:Pages')->find($page->getId());
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pages entity.');
        }
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('adminPages_edit', array('id' => $id)));
        }
        return $this->render('PagesBundle:Administration:pages/layout/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
