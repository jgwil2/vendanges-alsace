<?php

namespace Me\VendangesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="vendangeurs")
 */
class Vendangeur implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $pays;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $tel;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $salt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $disponible;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $tracteur;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $logement;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $vehicule;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dateDebut;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dateFin;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $motivation;

    public function __construct()
    {
        $this->setDisponible = false;
        $this->salt = sha1(uniqid(mt_rand(), true));
    }

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
     * Set nom
     *
     * @param string $nom
     * @return Vendangeur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
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
     * Set prenom
     *
     * @param string $prenom
     * @return Vendangeur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

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
     * Set adresse
     *
     * @param string $adresse
     * @return Vendangeur
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

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
     * Set code
     *
     * @param string $code
     * @return Vendangeur
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Vendangeur
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

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
     * Set pays
     *
     * @param string $pays
     * @return Vendangeur
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

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
     * Set tel
     *
     * @param string $tel
     * @return Vendangeur
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Vendangeur
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return $this->salt;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array('ROLE_VENDANGEUR');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Vendangeur
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Vendangeur
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Set disponible
     *
     * @param boolean $disponible
     * @return Vendangeur
     */
    public function setDisponible($disponible)
    {
        $this->disponible = $disponible;

        return $this;
    }

    /**
     * Get disponible
     *
     * @return boolean 
     */
    public function getDisponible()
    {
        return $this->disponible;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     * @return Vendangeur
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime 
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     * @return Vendangeur
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime 
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set motivation
     *
     * @param string $motivation
     * @return Vendangeur
     */
    public function setMotivation($motivation)
    {
        $this->motivation = $motivation;

        return $this;
    }

    /**
     * Get motivation
     *
     * @return string 
     */
    public function getMotivation()
    {
        return $this->motivation;
    }

    /**
     * Set tracteur
     *
     * @param boolean $tracteur
     * @return Vendangeur
     */
    public function setTracteur($tracteur)
    {
        $this->tracteur = $tracteur;

        return $this;
    }

    /**
     * Get tracteur
     *
     * @return boolean 
     */
    public function getTracteur()
    {
        return $this->tracteur;
    }

    /**
     * Set logement
     *
     * @param boolean $logement
     * @return Vendangeur
     */
    public function setLogement($logement)
    {
        $this->logement = $logement;

        return $this;
    }

    /**
     * Get logement
     *
     * @return boolean 
     */
    public function getLogement()
    {
        return $this->logement;
    }

    /**
     * Set vehicule
     *
     * @param boolean $vehicule
     * @return Vendangeur
     */
    public function setVehicule($vehicule)
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    /**
     * Get vehicule
     *
     * @return boolean 
     */
    public function getVehicule()
    {
        return $this->vehicule;
    }
}
