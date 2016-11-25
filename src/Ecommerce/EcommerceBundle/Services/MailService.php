<?php
/**
 * Created by PhpStorm.
 * User: mc
 * Date: 25/11/2016
 * Time: 11:20
 */

namespace Ecommerce\EcommerceBundle\Services;


use Ecommerce\EcommerceBundle\Entity\Commandes;
use Symfony\Component\Templating\EngineInterface;

class MailService
{
    
    private $mailer;
    private $templating;
    
    private $subject;
    private $body;
    private $destMail;
    
    public function __construct($mailer, EngineInterface $engineInterface)
    {
        $this->templating = $engineInterface;
        $this->mailer     = $mailer;
    }
    
    
    /**
     * @param $sheet
     */
    public function commandeConfirm(Commandes $commande)
    {
        $this->subject = sprintf('Confirmation de la commande: %s', $commande->getUtilisateur()->getUsernameCanonical());
        $this->doTemplate('@Ecommerce/Mail/validationCommande.html.twig', array('utilisateur' => $commande->getUtilisateur()));
        $this->destMail = $commande->getUtilisateur()->getEmailCanonical();
        $this->send();
    }
    
    /**
     * @param       $template
     * @param array $options
     */
    private function doTemplate($template, array $options)
    {
        $this->body = $this->templating->render($template, $options);
    }
    
    /**
     *
     */
    public function send()
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($this->subject)
            ->setFrom('no-reply@shop2shop.com')
            ->setTo($this->destMail)
            ->setBody(
                $this->body,
                'text/html'
            );
        
        $this->mailer->send($message);
    }
    
}