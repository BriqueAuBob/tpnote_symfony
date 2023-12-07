<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    private ?Artist $author = null;

    #[ORM\ManyToMany(targetEntity: Artist::class)]
    private Collection $drawers;

    #[ORM\ManyToOne(inversedBy: 'books')]
    private ?Category $category = null;

    public function __construct()
    {
        $this->drawers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getAuthor(): ?Artist
    {
        return $this->author;
    }

    public function setAuthor(?Artist $author): static
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, Artist>
     */
    public function getDrawers(): Collection
    {
        return $this->drawers;
    }

    public function addDrawer(Artist $drawer): static
    {
        if (!$this->drawers->contains($drawer)) {
            $this->drawers->add($drawer);
        }

        return $this;
    }

    public function removeDrawer(Artist $drawer): static
    {
        $this->drawers->removeElement($drawer);

        return $this;
    }

    public function getBooks(): ?string
    {
        return $this->books;
    }

    public function setBooks(string $books): static
    {
        $this->books = $books;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
}
