<?php

namespace Pages\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class PagesController extends Controller
{
    /**
     * @Route(
     *     "/page/{id}",
     *     name = "page",
     *     defaults={"id" = 1},
     *     requirements={"id" = "\d+"}
     *
     * )
     */
    public function pageAction($id)
    {
        $em   = $this->getDoctrine()->getManager();
        $page = $em->getRepository('PagesBundle:Pages')->find($id);
        $data = $em->getRepository('PagesBundle:Pages')->getPage($id);

        $response = new JsonResponse();


        $data = \GuzzleHttp\json_encode($data);


        if (!$page) {
            throw $this->createNotFoundException('La page n\'est pas trouvée');
        }

        return $this->render('PagesBundle:Default/layout:pages.html.twig', ['page' => $page, 'data' => $data]);
    }

    /**
     * @Route(
     *     "/menu",
     *     name = "menu",
     * )
     */
    public function menuAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('PagesBundle:Pages')->findAll();

        return $this->render('@Pages/Default/pages/modulesUsed/menu.html.twig', ['pages' => $pages]);
    }
}
