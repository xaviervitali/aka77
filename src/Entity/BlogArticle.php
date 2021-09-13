<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\BlogArticleRepository")
 */
class BlogArticle
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
     * message = "N'oubliez pas le titre de l'article."
     * )
     */
    private $titleArticle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $urlArticle;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(
     * message = "Ecrivez le contenu de votre article."
     * )
     */
    private $contentArticle;

    /**
     * @ORM\Column(type="integer")
     */
    private $likeArticle;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateModification;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $blogImg;

    // C'EST JUSTE POUR LE FORMULAIRE PAS POUR SQL
    public $uploadBlogImg;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     * message = "Choisissez une catégorie pour votre article."
     * )
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     * message = "Qui est l'auteur de l'article ?"
     * )
     */
    private $author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleArticle(): ?string
    {
        return $this->titleArticle;
    }

    public function setTitleArticle(string $titleArticle): self
    {
        $this->titleArticle = $titleArticle;

        return $this;
    }

    public function getUrlArticle(): ?string
    {
        return $this->urlArticle;
    }

    public function setUrlArticle(string $urlArticle): self
    {
        $this->urlArticle = $urlArticle;

        return $this;
    }

    public function getContentArticle(): ?string
    {
        return $this->contentArticle;
    }

    public function setContentArticle(string $contentArticle): self
    {
        $this->contentArticle = $contentArticle;

        return $this;
    }

    public function getLikeArticle(): ?int
    {
        return $this->likeArticle;
    }

    public function setLikeArticle(int $likeArticle): self
    {
        $this->likeArticle = $likeArticle;

        return $this;
    }

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->dateModification;
    }

    public function setDateModification(\DateTimeInterface $dateModification): self
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    public function getBlogImg()
    {
        return $this->blogImg;
    }

    public function setBlogImg($blogImg): self
    {
        $this->blogImg = $blogImg;

        return $this;
    }

    public function getUploadBlogImg()
    {
        return $this->uploadBlogImg;
    }

    public function setUploadBlogImg($uploadBlogImg) : self
    {
        $this->uploadBlogImg = $uploadBlogImg;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

}
