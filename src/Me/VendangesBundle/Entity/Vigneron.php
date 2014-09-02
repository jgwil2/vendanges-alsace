<?php

namespace Me\VendangesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="vignerons")
 */
class Vigneron implements UserInterface, \Serializable
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
    protected $email;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $site;

    /**
     * @ORM\Column(type="text")
     */
    protected $presentation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $photoPath;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $salt;

    /**
     * @ORM\OneToMany(targetEntity="Annonce", mappedBy="vigneron")
     */
    protected $annonces;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $active;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $photo;

    private $temp;

    /**
     * Sets file.
     *
     * @param UploadedFile $photo
     */
    public function setPhoto(UploadedFile $photo = null)
    {
        $this->photo = $photo;

        if(isset($this->photoPath)){
            $this->temp = $this->photoPath;
            $this->photoPath = null;
        }
        else{
            $this->photoPath = 'initial';
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if(null !== $this->getPhoto()){
            $filename = sha1(uniqid(mt_rand(), true));
            $this->photoPath = $filename.'.'.$this->getPhoto()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if(null === $this->getPhoto()){
            return;
        }

        $this->getPhoto()->move($this->getUploadRootDir(), $this->photoPath);

        if(isset($this->temp)){
            unlink($this->getUploadRootDir().'/'.$this->temp);
            $this->temp = null;
        }

        $this->photo = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if($photo == $this->getAbsolutePath()){
            unlink($photo);
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    // Constructor function sets account to active
    public function __construct()
    {
    	//$this->$annonces = new ArrayCollection();
        $this->active = true;
        $this->salt = sha1(uniqid(mt_rand(), true));
    }

    // Convenience functions for getting photo file path
    public function getAbsolutePath()
    {
        return null === $this->photoPath ? null : $this->getUploadRootDir().'/'.$this->photoPath;
    }

    public function getWebPath()
    {
        return null === $this->photoPath ? null : $this->getUploadDir().'/'.$this->photoPath;
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads';
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
     * @return Vigneron
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
     * Set adresse
     *
     * @param string $adresse
     * @return Vigneron
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
     * @return Vigneron
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
     * @return Vigneron
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
     * Set email
     *
     * @param string $email
     * @return Vigneron
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
     * Set site
     *
     * @param string $site
     * @return Vigneron
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return string 
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set presentation
     *
     * @param string $presentation
     * @return Vigneron
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Get presentation
     *
     * @return string 
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * Set photo
     *
     * @param string $photo
     * @return Vigneron
     */
    public function setPhotoPath($photoPath)
    {
        $this->photoPath = $photoPath;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string 
     */
    public function getPhotoPath()
    {
        return $this->photoPath;
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
        return array('ROLE_VIGNERON');
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
     * Add annonces
     *
     * @param \Me\VendangesBundle\Entity\Annonce $annonces
     * @return Vigneron
     */
    public function addAnnonce(\Me\VendangesBundle\Entity\Annonce $annonces)
    {
        $this->annonces[] = $annonces;

        return $this;
    }

    /**
     * Remove annonces
     *
     * @param \Me\VendangesBundle\Entity\Annonce $annonces
     */
    public function removeAnnonce(\Me\VendangesBundle\Entity\Annonce $annonces)
    {
        $this->annonces->removeElement($annonces);
    }

    /**
     * Get annonces
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAnnonces()
    {
        return $this->annonces;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Vigneron
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
     * @return Vigneron
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Vigneron
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
}
