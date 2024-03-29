<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategoryRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(
    'slug',message:'Ce slug existe déjà.'
)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:'integer')]
    private ?int $id = null;

    #[ORM\Column(type:'string',length: 255, unique: true)]
    #[Assert\NotBlank()]
    private ?string $name;

    #[ORM\Column(type:'string',length: 255, unique: true)]
    #[Assert\NotBlank()]
    private ?string $slug='';

    #[ORM\Column(type:'text',nullable:true)]
    private ?string $description = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull()]
    private \DateTimeImmutable $createdAt;

    #[ORM\ManyToMany(targetEntity: Post::class, inversedBy: 'categories')]
    private Collection $posts;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->posts = new ArrayCollection();
    }
    #[ORM\PrePersist]
    public function prePersist()
    {
        $this->slug = ( new Slugify())->slugify($this->name);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }


    public function setName(string $name):self
    {
        $this->name = $name;

        return $this;
    }

 
    public function getSlug(): ?string
    {
        return $this->slug;
    }


    public function setSlug(string $slug):self
    {
        $this->slug = $slug;

        return $this;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }


    public function setDescription(?string $description):self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt():\DateTimeImmutable
    {
        return $this->createdAt;
    }

  
    public function setCreatedAt(\DateTimeImmutable $createdAt):self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): static
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
        }

        return $this;
    }

    public function removePost(Post $post): static
    {
        $this->posts->removeElement($post);

        return $this;
    }
}
