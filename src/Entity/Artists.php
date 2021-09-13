<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArtistsRepository")
 * @UniqueEntity("emailArtist", message="desole email deja pris ({{ value }})")
 * @UniqueEntity("pseudo", message="desole pseudo deja pris ({{ value }})")
 */
class Artists
	implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
	 * @Assert\NotBlank
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $baseline;

    /**
     * @ORM\Column(type="integer")
     */
    private $droit;

    /**
     * @ORM\Column(type="string", length=255)
	 * @Assert\NotBlank
     * @Assert\Length(
     *      min = 6,
     *      max = 14,
     *      minMessage = "trop court {{ limit }}",
     *      maxMessage = "trop long {{ limit }}"
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $urlPageArtist;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=160)
	 * @Assert\NotBlank
     * @Assert\Email(
     *     message = "email invalide '{{ value }}'"
     * )
     */
    private $emailArtist;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $urlImageAvatar;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $urlSiteWebArtist;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $urlFacebookArtist;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $urlInstagramArtist;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getBaseline(): ?string
    {
        return $this->baseline;
    }

    public function setBaseline(?string $baseline): self
    {
        $this->baseline = $baseline;

        return $this;
    }

    public function getDroit(): ?int
    {
        return $this->droit;
    }

    public function setDroit(int $droit): self
    {
        $this->droit = $droit;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUrlPageArtist(): ?string
    {
        return $this->urlPageArtist;
    }

    public function setUrlPageArtist(string $urlPageArtist): self
    {
        $this->urlPageArtist = $urlPageArtist;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEmailArtist(): ?string
    {
        return $this->emailArtist;
    }

    public function setEmailArtist(string $emailArtist): self
    {
        $this->emailArtist = $emailArtist;

        return $this;
    }

    public function getUrlImageAvatar(): ?string
    {
        return $this->urlImageAvatar;
    }

    public function setUrlImageAvatar(string $urlImageAvatar): self
    {
        $this->urlImageAvatar = $urlImageAvatar;

        return $this;
    }

    public function getUrlSiteWebArtist(): ?string
    {
        return $this->urlSiteWebArtist;
    }

    public function setUrlSiteWebArtist(?string $urlSiteWebArtist): self
    {
        $this->urlSiteWebArtist = $urlSiteWebArtist;

        return $this;
    }

    public function getUrlFacebookArtist(): ?string
    {
        return $this->urlFacebookArtist;
    }

    public function setUrlFacebookArtist(?string $urlFacebookArtist): self
    {
        $this->urlFacebookArtist = $urlFacebookArtist;

        return $this;
    }

    public function getUrlInstagramArtist(): ?string
    {
        return $this->urlInstagramArtist;
    }

    public function setUrlInstagramArtist(?string $urlInstagramArtist): self
    {
        $this->urlInstagramArtist = $urlInstagramArtist;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function eraseCredentials() {}

    public function getSalt() {}


    public function getUsername(){
        return $this->pseudo;
    }
    /** @see Serializable::serialize() */
    public function serialize()
    {
        // ATTENTION: AJOUTER LES INFOS A MEMORISER DANS LA SESSION
        return serialize(array(
            $this->id,
            $this->pseudo,
            $this->password,
            $this->emailArtist,
            $this->droit,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->pseudo,
            $this->password,
            $this->emailArtist,
            $this->droit,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }

        public function getRoles()
    {
        if ($this->droit >= 9)
            return ['ROLE_ADMIN'];
        elseif ($this->droit >= 3)
            return ['ROLE_USER'];
        else
            return [];
    }
}
