<?php

namespace Me\VendangesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Me\VendangesBundle\Entity\AnnonceRepository")
 * @ORM\Table(name="annonces")
 */
class Annonce
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
	protected $titre;

    /**
     * @ORM\Column(type="datetime")
     */
	protected $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     */
	protected $dateFin;

    /**
     * @ORM\Column(type="boolean")
     */
	protected $logement;

    /**
     * @ORM\Column(type="boolean")
     */
	protected $repas;

    /**
     * @ORM\Column(type="string", length=255)
     */
	protected $remuneration;

    /**
     * @ORM\Column(type="text")
     */
	protected $texte;

    /**
     * @ORM\Column(type="integer")
     */
	protected $places;

    /**
     * @ORM\Column(type="boolean")
     */
	protected $active;

    /**
     * @ORM\ManyToOne(targetEntity="Vigneron", inversedBy="annonces")
     * @ORM\JoinColumn(name="vigneron", referencedColumnName="id")
     */
    protected $vigneron;

    public function __construct()
    {
        $this->setActive(true);
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
     * Set titre
     *
     * @param string $titre
     * @return Annonce
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     * @return Annonce
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
     * @return Annonce
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
     * Set logement
     *
     * @param boolean $logement
     * @return Annonce
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
     * Set repas
     *
     * @param boolean $repas
     * @return Annonce
     */
    public function setRepas($repas)
    {
        $this->repas = $repas;

        return $this;
    }

    /**
     * Get repas
     *
     * @return boolean 
     */
    public function getRepas()
    {
        return $this->repas;
    }

    /**
     * Set remuneration
     *
     * @param string $remuneration
     * @return Annonce
     */
    public function setRemuneration($remuneration)
    {
        $this->remuneration = $remuneration;

        return $this;
    }

    /**
     * Get remuneration
     *
     * @return string 
     */
    public function getRemuneration()
    {
        return $this->remuneration;
    }

    /**
     * Set texte
     *
     * @param string $texte
     * @return Annonce
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;

        return $this;
    }

    /**
     * Get texte
     *
     * @return string 
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * Set places
     *
     * @param integer $places
     * @return Annonce
     */
    public function setPlaces($places)
    {
        $this->places = $places;

        return $this;
    }

    /**
     * Get places
     *
     * @return integer 
     */
    public function getPlaces()
    {
        return $this->places;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Annonce
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set vigneron
     *
     * @param \Me\VendangesBundle\Entity\Vigneron $vigneron
     * @return Annonce
     */
    public function setVigneron(\Me\VendangesBundle\Entity\Vigneron $vigneron = null)
    {
        $this->vigneron = $vigneron;

        return $this;
    }

    /**
     * Get vigneron
     *
     * @return \Me\VendangesBundle\Entity\Vigneron 
     */
    public function getVigneron()
    {
        return $this->vigneron;
    }
}
