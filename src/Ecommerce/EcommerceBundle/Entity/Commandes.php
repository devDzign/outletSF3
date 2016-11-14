<?php

namespace Ecommerce\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;


/**
 * Commandes
 *
 * @ORM\Table(name="mc_commandes")
 * @ORM\Entity(repositoryClass="Ecommerce\EcommerceBundle\Repository\CommandesRepository")
 */
class Commandes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="commandes")
     * @ORM\JoinColumn(nullable=true)
     */
    private $utilisateur;

    /**
     * @var boolean
     *
     * @ORM\Column(name="valider", type="boolean")
     */
    private $valider;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    /**
     * @var integer
     *
     * @ORM\Column(name="reference", type="integer")
     */
    private $reference;
    /**
     * @var array
     *
     * @ORM\Column(name="commande", type="array")
     */
    private $commande;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get valider
     *
     * @return boolean
     */
    public function getValider()
    {
        return $this->valider;
    }
    
    /**
     * Set valider
     *
     * @param boolean $valider
     * @return Commandes
     */
    public function setValider($valider)
    {
        $this->valider = $valider;
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Commandes
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Get reference
     *
     * @return integer
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set reference
     *
     * @param integer $reference
     * @return Commandes
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * Get commande
     *
     * @return array
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * Set commande
     *
     * @param array $commande
     * @return Commandes
     */
    public function setCommande($commande)
    {
        $this->commande = $commande;
        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return User
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set utilisateur
     *
     * @param User $utilisateur
     * @return Commandes
     */
    public function setUtilisateur(User $utilisateur = null)
    {

        $this->utilisateur = $utilisateur;
        return $this;
    }
}
