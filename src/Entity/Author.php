<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    private ?int $nb_books = null;

    #[ORM\OneToMany(mappedBy: 'Author', targetEntity: Book::class)]
    private Collection $books;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Magazine::class)]
    private Collection $relation;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Histoire::class)]
    private Collection $histoires;

    
    #[ORM\Column]
   
    public function __construct()
    {
        
        $this->books = new ArrayCollection();
        $this->relation = new ArrayCollection();
        $this->histoires = new ArrayCollection();
    }

   
   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getNbBooks(): ?int
    {
        return $this->nb_books;
    }

    public function setNbBooks(int $nb_books): static
    {
        $this->nb_books = $nb_books;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): static
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->setAuthor($this);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getAuthor() === $this) {
                $book->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, magazine>
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addReation(magazine $relation): static
    {
        if (!$this->relation->contains($relation)) {
            $this->relation->add($relation);
            $relation->setAuthor($this);
        }

        return $this;
    }

    public function removeRelation(magazine $relation): static
    {
        if ($this->relation->removeElement($relation)) {
            // set the owning side to null (unless already changed)
            if ($relation->getAuthor() === $this) {
                $relation->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Histoire>
     */
    public function getHistoires(): Collection
    {
        return $this->histoires;
    }

    public function addHistoire(Histoire $histoire): static
    {
        if (!$this->histoires->contains($histoire)) {
            $this->histoires->add($histoire);
            $histoire->setAuthor($this);
        }

        return $this;
    }

    public function removeHistoire(Histoire $histoire): static
    {
        if ($this->histoires->removeElement($histoire)) {
            // set the owning side to null (unless already changed)
            if ($histoire->getAuthor() === $this) {
                $histoire->setAuthor(null);
            }
        }

        return $this;
    }

   




    

    

    
}
