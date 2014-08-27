<?php

namespace Me\VendangesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="reponse")
 */
class Reponse
{
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Vendangeur")
     * @ORM\JoinColumn(name="vendangeur_id", referencedColumnName="id")
     */
	protected $vendangeur;

	/**
     * @ORM\ManyToOne(targetEntity="Annonce")
     * @ORM\JoinColumn(name="annonce_id", referencedColumnName="id")
     */
	protected $annonce;

	/**
     * @ORM\Column(type="string", length=255)
     */
	protected $sujet;

	/**
     * @ORM\Column(type="text")
     */
	protected $message;

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
     * Set message
     *
     * @param string $message
     * @return Reponse
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set vendangeur
     *
     * @param \Me\VendangesBundle\Entity\Vendangeur $vendangeur
     * @return Reponse
     */
    public function setVendangeur(\Me\VendangesBundle\Entity\Vendangeur $vendangeur = null)
    {
        $this->vendangeur = $vendangeur;

        return $this;
    }

    /**
     * Get vendangeur
     *
     * @return \Me\VendangesBundle\Entity\Vendangeur 
     */
    public function getVendangeur()
    {
        return $this->vendangeur;
    }

    /**
     * Set annonce
     *
     * @param \Me\VendangesBundle\Entity\Annonce $annonce
     * @return Reponse
     */
    public function setAnnonce(\Me\VendangesBundle\Entity\Annonce $annonce = null)
    {
        $this->annonce = $annonce;

        return $this;
    }

    /**
     * Get annonce
     *
     * @return \Me\VendangesBundle\Entity\Annonce 
     */
    public function getAnnonce()
    {
        return $this->annonce;
    }

    /**
     * Set sujet
     *
     * @param string $sujet
     * @return Reponse
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;

        return $this;
    }

    /**
     * Get sujet
     *
     * @return string 
     */
    public function getSujet()
    {
        return $this->sujet;
    }
}
