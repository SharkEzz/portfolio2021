<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BlogPostCommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlogPostCommentRepository::class)
 */
#[ApiResource]
class BlogPostComment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=2000)
     */
    private string $content;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private string $authorIp;

    /**
     * @ORM\ManyToOne(targetEntity=BlogPost::class, inversedBy="blogPostComments")
     * @ORM\JoinColumn(nullable=false)
     */
    private BlogPost $blogPost;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAuthorIp(): ?string
    {
        return $this->authorIp;
    }

    public function setAuthorIp(string $authorIp): self
    {
        $this->authorIp = $authorIp;

        return $this;
    }

    public function getBlogPost(): BlogPost
    {
        return $this->blogPost;
    }

    public function setBlogPost(BlogPost $blogPost): self
    {
        $this->blogPost = $blogPost;

        return $this;
    }
}
