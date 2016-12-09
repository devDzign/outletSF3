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
     *
     * @param EntityManager $em
     * @param TokenStorage  $tokenStorage
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
        $this->tokenStorage = $tokenStorage->getToken();
        $this->session      = new Session();
        $this->html2pdf     = $html2pdf->create();
        $this->router       = $router;
        $this->templating   = $templating;
    }
    
    public function generateFactureHtmlToPdf($id, $redirectTemplate = 'factures')
    {
        $facture   = null;
        $role      = [];
        $rolesUser = $this->tokenStorage->getRoles();
        foreach ($rolesUser as $index => $item) {
            $roles[] = $item->getRole();
        }
    
        if (!in_array('ROLE_ADMIN', $roles)) {
        
        
            $facture = $this->em->getRepository('EcommerceBundle:Commandes')->findOneBy(
                array(
                    'utilisateur' => $this->tokenStorage->getUser(),
                    'valider' => 1,
                    'id' => $id
                )
            );
        } else {
        
            $facture = $this->em->getRepository('EcommerceBundle:Commandes')->findOneBy(
                array(
                    'valider' => 1,
                    'id' => $id
                )
            );
        }
    
    
        if (!$facture) {
        
            $this->session->getFlashBag()->add('errors', 'Une erreur est survenue sur service generateur');
        
            return new RedirectResponse($this->router->generate($redirectTemplate));
        }
    
    
        $this->calculeFacture($facture);
        $this->html2pdf->Output('Facture.pdf');
        $response = new Response();
        $response->headers->set('Content-type', 'application/pdf');
    
        return $response;
    }
    
    private function calculeFacture($facture)
    {
        
        $html = $this->templating->render('UserBundle:Default:layout/facturePDF.html.twig', array('facture' => $facture));
        $this->html2pdf->pdf->SetAuthor('Shop2Shop');
        $this->html2pdf->pdf->SetTitle('Facture ' . $facture->getReference());
        $this->html2pdf->pdf->SetSubject('Facture Shop2Shop');
        $this->html2pdf->pdf->SetKeywords('facture,Shop2Shop');
        $this->html2pdf->pdf->SetDisplayMode('real');
        $this->html2pdf->writeHTML($html);
        
        return $this->html2pdf;
    }
    
    public function generateFactureCommand($facture)
    {
        return $this->calculeFacture($facture);
    }
    
}
