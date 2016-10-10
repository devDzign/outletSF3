<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ecommerce\EcommerceBundle\Entity\Commandes;
use Ecommerce\EcommerceBundle\Entity\UtilisateursAdresses;
use FOS\UserBundle\Model\User as BaseUser;


/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    public function __construct()
    {
        parent::__construct();
        $this->commandes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->adresses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @ORM\OneToMany(targetEntity="Ecommerce\EcommerceBundle\Entity\Commandes", mappedBy="utilisateur", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $commandes;

    /**
     * @ORM\OneToMany(targetEntity="Ecommerce\EcommerceBundle\Entity\UtilisateursAdresses", mappedBy="utilisateur", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $adresses;
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
     * Add commandes
     *
     * @param Commandes $commandes
     * @return Utilisateurs
     */
    public function addCommande(Commandes $commandes)
    {
        $this->commandes[] = $commandes;
        return $this;
    }
    /**
     * Remove commandes
     *
     * @param Commandes $commandes
     */
    public function removeCommande(Commandes $commandes)
    {
        $this->commandes->removeElement($commandes);
    }
    /**
     * Get commandes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandes()
    {
        return $this->commandes;
    }
    /**
     * Add adresses
     *
     * @param UtilisateursAdresses $adresses
     * @return Utilisateurs
     */
    public function addAdress(UtilisateursAdresses $adresses)
    {
        $this->adresses[] = $adresses;
        return $this;
    }
    /**
     * Remove adresses
     *
     * @param UtilisateursAdresses $adresses
     */
    public function removeAdress(UtilisateursAdresses $adresses)
    {
        $this->adresses->removeElement($adresses);
    }
    /**
     * Get adresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdresses()
    {
        return $this->adresses;
    }
}