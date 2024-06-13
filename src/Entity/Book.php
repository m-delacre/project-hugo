<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 5)]
    #[Assert\Regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', message: "Ceci n'est pas un slug valide.")]
    private ?string $slug = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive()]
    private ?int $pages = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $author = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $note = null;

    /**
     * @var Collection<int, BookList>
     */
    #[ORM\ManyToMany(targetEntity: BookList::class, mappedBy: 'books')]
    private Collection $bookLists;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $addedBy = null;

    public function __construct()
    {
        $this->bookLists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPages(): ?int
    {
        return $this->pages;
    }

    public function setPages(?int $pages): static
    {
        $this->pages = $pages;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return Collection<int, BookList>
     */
    public function getBookLists(): Collection
    {
        return $this->bookLists;
    }

    public function addBookList(BookList $bookList): static
    {
        if (!$this->bookLists->contains($bookList)) {
            $this->bookLists->add($bookList);
            $bookList->addBook($this);
        }

        return $this;
    }

    public function removeBookList(BookList $bookList): static
    {
        if ($this->bookLists->removeElement($bookList)) {
            $bookList->removeBook($this);
        }

        return $this;
    }

    public function getAddedBy(): ?User
    {
        return $this->addedBy;
    }

    public function setAddedBy(?User $addedBy): static
    {
        $this->addedBy = $addedBy;

        return $this;
    }
}
