<?php
/**
 * Created by PhpStorm.
 * User: mc
 * Date: 10/10/2016
 * Time: 21:30
 */

namespace Ecommerce\EcommerceBundle\Services;


use Doctrine\ORM\EntityManager;
use Ensepar\Html2pdfBundle\Factory\Html2pdfFactory;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class GenerateFacturePdf
 * @package Ecommerce\EcommerceBundle\Services
 */
class GenerateFacturePdf
{
    
    private $em;
    private $tokenStorage;
    private $session;
    private $router;
    private $templating;
    
    /**
     * GetReference constructor.
     * @param EntityManager $em
     * @param TokenStorage $tokenStorage
     */
    public function __construct(
        EntityManager $em,
        TokenStorage $tokenStorage,
        Html2pdfFactory $html2pdf,
        Router $router,
        EngineInterface $templating
    )
    {
        $this->em           = $em;
        $this->tokenStorage = $tokenStorage;
        $this->session      = new Session();
        $this->html2pdf     = $html2pdf->create();
        $this->router       = $router;
        $this->templating   = $templating;
    }
    
    public function generateFactureHtmlToPdf($id, $redirectTemplate = 'factures')
    {
        $facture = $this->em->getRepository('EcommerceBundle:Commandes')->findOneBy(
            array(
                'utilisateur' => $this->tokenStorage->getToken()->getUser(),
                'valider' => 1,
                'id' => $id
            )
        );
        
        if (!$facture) {
            
            $this->session->getFlashBag()->add('error', 'Une erreur est survenue');
    
            return new RedirectResponse($this->router->generate($redirectTemplate));
        }
        
        $html = $this->templating->render('UserBundle:Default:layout/facturePDF.html.twig', array('facture' => $facture));
        
        $this->html2pdf->pdf->SetAuthor('Shop2Shop');
        $this->html2pdf->pdf->SetTitle('Facture ' . $facture->getReference());
        $this->html2pdf->pdf->SetSubject('Facture DevAndClick');
        $this->html2pdf->pdf->SetKeywords('facture,devandclick');
        $this->html2pdf->pdf->SetDisplayMode('real');
        $this->html2pdf->writeHTML($html);
        $this->html2pdf->Output('Facture.pdf');
        
        $response = new Response();
        $response->headers->set('Content-type', 'application/pdf');
        
        return $response;
    }
    
}
