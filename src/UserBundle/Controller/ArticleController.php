<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use UserBundle\Model\ArticleSearch;
use UserBundle\Form\ArticleSearchType;

class ArticleController extends Controller
{
    /**
     * @Route(
     *     "/elastica",
     *      name = "searchElastica"
     *     )
     */
    public function listAction(Request $request)
    {
        $articleSearch = new ArticleSearch();

        $articleSearchForm = $this->createForm(ArticleSearchType::class,$articleSearch);

        $articleSearchForm->handleRequest($request);
        $articleSearch = $articleSearchForm->getData();

        $elasticaManager = $this->get('fos_elastica.manager');
        $results = $elasticaManager->getRepository('UserBundle:Article')->search($articleSearch);

        return $this->render('UserBundle:Article:list.html.twig',array(
            'results' => $results,
            'articleSearchForm' => $articleSearchForm->createView(),
        ));
    }
}

