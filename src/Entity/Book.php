<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ApiResource]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $isbn = null;

    #[ORM\Column]
    private ?bool $isAvailable = null;

    #[ORM\Column(length: 255)]
    private ?string $cover = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $resume = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'books')]
    private Collection $idCategory;

    #[ORM\ManyToOne(inversedBy: 'books')]
    private ?Box $idBox = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    private ?Borrow $idBorrow = null;

    public function __construct()
    {
        $this->idCategory = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->idBox;
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

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function isIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getIdCategory(): Collection
    {
        return $this->idCategory;
    }

    public function addIdCategory(Category $idCategory): self
    {
        if (!$this->idCategory->contains($idCategory)) {
            $this->idCategory->add($idCategory);
        }

        return $this;
    }

    public function removeIdCategory(Category $idCategory): self
    {
        $this->idCategory->removeElement($idCategory);

        return $this;
    }

    public function getIdBox(): ?Box
    {
        return $this->idBox;
    }

    public function setIdBox(?Box $idBox): self
    {
        $this->idBox = $idBox;

        return $this;
    }

    public function getIdBorrow(): ?Borrow
    {
        return $this->idBorrow;
    }

    public function setIdBorrow(?Borrow $idBorrow): self
    {
        $this->idBorrow = $idBorrow;

        return $this;
    }

}
