<?php
/**
 * Created by PhpStorm.
 * User: mc
 * Date: 10/10/2016
 * Time: 21:30
 */

namespace Ecommerce\EcommerceBundle\Services;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class FactureManager
 * @package Ecommerce\EcommerceBundle\Services
 */
class FactureManager
{
    
    
    private $em;
    private $repositoryProduit;
    private $repositoryUtilisateursAdresses;
    private $session;
    private $request;
    private $commande;
    
    
    /**
     * PanierManager constructor.
     * @param EntityManager $em
     * @param RequestStack $request
     */
    public function __construct(
        EntityManager $em,
        RequestStack $request
    )
    {
        $this->em                             = $em;
        $this->repositoryProduit              = $this->em->getRepository('EcommerceBundle:Produits');
        $this->repositoryUtilisateursAdresses = $this->em->getRepository('EcommerceBundle:UtilisateursAdresses');
        $this->session                        = new Session();
        $this->request                        = $request->getMasterRequest();
        $this->commande                       = array();
    }
    
    public function facture()
    {
        
        $generator = random_bytes(20);
        $adresse   = $this->session->get('adresse');
        $panier    = $this->session->get('panier');
        $totalHT   = 0;
        $totalTTC  = 0;
        
        $facturation = $this->repositoryUtilisateursAdresses->find($adresse['facturation']);
        $livraison   = $this->repositoryUtilisateursAdresses->find($adresse['livraison']);
        $produits    = $this->repositoryProduit->findArray(array_keys($this->session->get('panier')));
        
        foreach ($produits as $produit) {
            $prixHT  = ($produit->getPrix() * $panier[$produit->getId()]);
            $prixTTC = ($produit->getPrix() * $panier[$produit->getId()] / $produit->getTva()->getMultiplicate());
            $totalHT += $prixHT;
            $totalTTC += $prixTTC;
            
            if (!isset($this->commande['tva']['%' . $produit->getTva()->getValeur()])) {
                $this->commande['tva']['%' . $produit->getTva()->getValeur()] = round($prixTTC - $prixHT, 2);
            } else {
                $this->commande['tva']['%' . $produit->getTva()->getValeur()] += round($prixTTC - $prixHT, 2);
            }
            
            
            $this->commande['produit'][$produit->getId()] = array('reference' => $produit->getNom(),
                                                                  'quantite' => $panier[$produit->getId()],
                                                                  'prixHT' => round($produit->getPrix(), 2),
                                                                  'prixTTC' => round($produit->getPrix() / $produit->getTva()->getMultiplicate(), 2));
        }
        
        $this->commande['livraison']   = array('prenom' => $livraison->getPrenom(),
                                               'nom' => $livraison->getNom(),
                                               'telephone' => $livraison->getTelephone(),
                                               'adresse' => $livraison->getAdresse(),
                                               'cp' => $livraison->getCp(),
                                               'ville' => $livraison->getVille(),
                                               'pays' => $livraison->getPays(),
                                               'complement' => $livraison->getComplement());
        $this->commande['facturation'] = array('prenom' => $facturation->getPrenom(),
                                               'nom' => $facturation->getNom(),
                                               'telephone' => $facturation->getTelephone(),
                                               'adresse' => $facturation->getAdresse(),
                                               'cp' => $facturation->getCp(),
                                               'ville' => $facturation->getVille(),
                                               'pays' => $facturation->getPays(),
                                               'complement' => $facturation->getComplement());
        
        $this->commande['prixHT']  = round($totalHT, 2);
        $this->commande['prixTTC'] = round($totalTTC, 2);
        $this->commande['token']   = bin2hex($generator);
        
        return $this->commande;
    }
    
}