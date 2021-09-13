<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\GalleryRepository")
 */
class Gallery
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     * message = "Le nom de l'image ne doit pas être vide"
     * )
     */
    private $imgName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $urlImgOriginal;

    
    public $uploadGalleryForm;

    /**
     * @ORM\Column(type="integer")
     */
    private $imgLike;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateUpdate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     * message = "Ajoutez l'artiste à l'origine de l'image"
     * )
     */
    private $Artist;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imgMedium;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imgSmall;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $imgDescription;


    public function __construct()
    {
        $this->idArtist = new ArrayCollection();
    }

    public function getId() : ? int
    {
        return $this->id;
    }

    public function getImgName() : ? string
    {
        return $this->imgName;
    }

    public function setImgName(string $imgName) : self
    {
        $this->imgName = $imgName;

        return $this;
    }

    public function getUrlImgOriginal() : ? string
    {
        return $this->urlImgOriginal;
    }

    public function setUrlImgOriginal(string $urlImgOriginal) : self
    {
        $this->urlImgOriginal = $urlImgOriginal;

        return $this;
    }

    public function getUploadGalleryForm()
    {
        return $this->uploadGalleryForm;
    }

    public function setUploadGalleryForm($uploadGalleryForm) : self
    {
        $this->uploadGalleryForm = $uploadGalleryForm;

        return $this;
    }


    public function getImgLike() : ? int
    {
        return $this->imgLike;
    }

    public function setImgLike(int $imgLike) : self
    {
        $this->imgLike = $imgLike;

        return $this;
    }

    public function getDateUpdate() : ? \DateTimeInterface
    {
        return $this->dateUpdate;
    }

    public function setDateUpdate(\DateTimeInterface $dateUpdate) : self
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

    public function getArtist(): ?string
    {
        return $this->Artist;
    }

    public function setArtist(string $Artist) : self
    {
        $this->Artist = $Artist;

        return $this;
    }

    public function getImgMedium() : ? string
    {
        return $this->imgMedium;
    }

    public function setImgMedium(string $imgMedium) : self
    {
        $this->imgMedium = $imgMedium;

        return $this;
    }

    public function getImgSmall() : ? string
    {
        return $this->imgSmall;
    }

    public function setImgSmall(string $imgSmall) : self
    {
        $this->imgSmall = $imgSmall;

        return $this;
    }

    public function getImgDescription() : ? string
    {
        return $this->imgDescription;
    }

    public function setImgDescription(? string $imgDescription) : self
    {
        $this->imgDescription = $imgDescription;

        return $this;
    }
}