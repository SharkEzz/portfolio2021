<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BlogPostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlogPostRepository::class)
 */
#[ApiResource]
class BlogPost
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $slug;

    /**
     * @ORM\Column(type="text")
     */
    private string $content;

    /**
     * @ORM\ManyToOne(targetEntity=BlogCategory::class, inversedBy="blogPosts")
     * @ORM\JoinColumn(nullable=false)
     */
    private BlogCategory $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $imagePath;

    /**
     * @ORM\OneToMany(targetEntity=BlogPostComment::class, mappedBy="blogPost", orphanRemoval=true)
     */
    private $blogPostComments;

    public function __construct()
    {
        $this->blogPostComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCategory(): ?BlogCategory
    {
        return $this->category;
    }

    public function setCategory(?BlogCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(?string $imagePath): self
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * @return Collection|BlogPostComment[]
     */
    public function getBlogPostComments(): Collection
    {
        return $this->blogPostComments;
    }

    public function addBlogPostComment(BlogPostComment $blogPostComment): self
    {
        if (!$this->blogPostComments->contains($blogPostComment)) {
            $this->blogPostComments[] = $blogPostComment;
            $blogPostComment->setBlogPost($this);
        }

        return $this;
    }

    public function removeBlogPostComment(BlogPostComment $blogPostComment): self
    {
        if ($this->blogPostComments->removeElement($blogPostComment)) {
            // set the owning side to null (unless already changed)
            if ($blogPostComment->getBlogPost() === $this) {
                $blogPostComment->setBlogPost(null);
            }
        }

        return $this;
    }
}
