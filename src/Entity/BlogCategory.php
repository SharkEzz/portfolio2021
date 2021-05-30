<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BlogCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BlogCategoryRepository::class)
 */
#[ApiResource(
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['category_item_read']
            ]
        ],
        'patch',
        'delete'],
    normalizationContext: [
        'groups' => [
            'category_read'
        ]
    ]
)]
class BlogCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['category_read', 'category_item_read'])]
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['post_read', 'category_read', 'category_item_read'])]
    private string $name;

    /**
     * @ORM\OneToMany(targetEntity=BlogPost::class, mappedBy="category")
     */
    #[Groups(['category_item_read'])]
    private Collection $blogPosts;

    public function __construct()
    {
        $this->blogPosts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getBlogPosts(): Collection
    {
        return $this->blogPosts;
    }

    public function addBlogPost(BlogPost $blogPost): self
    {
        if (!$this->blogPosts->contains($blogPost)) {
            $this->blogPosts[] = $blogPost;
            $blogPost->setCategory($this);
        }

        return $this;
    }

    public function removeBlogPost(BlogPost $blogPost): self
    {
        if ($this->blogPosts->removeElement($blogPost)) {
            // set the owning side to null (unless already changed)
            if ($blogPost->getCategory() === $this) {
                $blogPost->setCategory(null);
            }
        }

        return $this;
    }
}
