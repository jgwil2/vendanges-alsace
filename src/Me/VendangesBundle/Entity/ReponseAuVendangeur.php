<?php

namespace Me\VendangesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReponseAuVendangeur
 *
 * @ORM\Table(name="reponse_au_vendangeur")
 * @ORM\Entity
 */
class ReponseAuVendangeur
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
     * @var integer
     * @ORM\ManyToOne(targetEntity="Vigneron")
     * @ORM\JoinColumn(name="vigneron_id", referencedColumnName="id")
     */
    private $vigneronId;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Vendangeur")
     * @ORM\JoinColumn(name="vendangeur_id", referencedColumnName="id")
     */
    private $vendangeurId;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="sujet", type="string", length=255)
     */
    private $sujet;


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
     * Set vigneronId
     *
     * @param integer $vigneronId
     * @return ReponseAuVendangeur
     */
    public function setVigneronId($vigneronId)
    {
        $this->vigneronId = $vigneronId;

        return $this;
    }

    /**
     * Get vigneronId
     *
     * @return integer 
     */
    public function getVigneronId()
    {
        return $this->vigneronId;
    }

    /**
     * Set vendangeurId
     *
     * @param integer $vendangeurId
     * @return ReponseAuVendangeur
     */
    public function setVendangeurId($vendangeurId)
    {
        $this->vendangeurId = $vendangeurId;

        return $this;
    }

    /**
     * Get vendangeurId
     *
     * @return integer 
     */
    public function getVendangeurId()
    {
        return $this->vendangeurId;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return ReponseAuVendangeur
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
     * Set sujet
     *
     * @param string $sujet
     * @return ReponseAuVendangeur
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
