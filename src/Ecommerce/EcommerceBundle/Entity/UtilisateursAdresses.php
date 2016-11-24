<?php
namespace Ecommerce\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * UtilisateursAdresses
 *
 * @ORM\Table("mc_utilisateurs_adresses")
 * @ORM\Entity(repositoryClass="Ecommerce\EcommerceBundle\Repository\UtilisateursAdressesRepository")
 */
class UtilisateursAdresses
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
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="commandes", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $utilisateur;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=125)
     */
    private $nom;
    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=125)
     */
    private $prenom;
    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=30)
     */
    private $telephone;
    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;
    /**
     * @var string
     *
     * @ORM\Column(name="cp", type="string", length=10)
     */
    private $cp;
    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=125)
     */
    private $pays;
    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=125)
     */
    private $ville;
    /**
     * @var string
     *
     * @ORM\Column(name="complement", type="string", length=255, nullable=true)
     */
    private $complement;
    
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
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }
    
    /**
     * Set nom
     *
     * @param string $nom
     * @return UtilisateursAdresses
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        
        return $this;
    }
    
    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }
    
    /**
     * Set prenom
     *
     * @param string $prenom
     * @return UtilisateursAdresses
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        
        return $this;
    }
    
    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }
    
    /**
     * Set telephone
     *
     * @param string $telephone
     * @return UtilisateursAdresses
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
        
        return $this;
    }
    
    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }
    
    /**
     * Set adresse
     *
     * @param string $adresse
     * @return UtilisateursAdresses
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
        
        return $this;
    }
    
    /**
     * Get cp
     *
     * @return string
     */
    public function getCp()
    {
        return $this->cp;
    }
    
    /**
     * Set cp
     *
     * @param string $cp
     * @return UtilisateursAdresses
     */
    public function setCp($cp)
    {
        $this->cp = $cp;
        
        return $this;
    }
    
    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }
    
    /**
     * Set pays
     *
     * @param string $pays
     * @return UtilisateursAdresses
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
        
        return $this;
    }
    
    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }
    
    /**
     * Set ville
     *
     * @param string $ville
     * @return UtilisateursAdresses
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
        
        return $this;
    }
    
    /**
     * Get complement
     *
     * @return string
     */
    public function getComplement()
    {
        return $this->complement;
    }
    
    /**
     * Set complement
     *
     * @param string $complement
     * @return UtilisateursAdresses
     */
    public function setComplement($complement)
    {
        $this->complement = $complement;
        
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
     *
     * @return Commandes
     */
    public function setUtilisateur(User $utilisateur = null)
    {
    
        $this->utilisateur = $utilisateur;
        return $this;
    }
}