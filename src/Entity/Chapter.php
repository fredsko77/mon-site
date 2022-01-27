<?php

namespace App\Entity;

use App\Repository\ChapterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChapterRepository::class)
 */
class Chapter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime")
     */
    private $cratedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="chapters")
     */
    private $book;

    /**
     * @ORM\OneToMany(targetEntity=Page::class, mappedBy="chapter")
     */
    private $pages;

    /**
     * @ORM\ManyToOne(targetEntity=Chapter::class, inversedBy="chapter")
     */
    private $parentChapter;

    /**
     * @ORM\OneToMany(targetEntity=Chapter::class, mappedBy="parentChapter")
     */
    private $chapter;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
        $this->chapter = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getCratedAt(): ?\DateTimeInterface
    {
        return $this->cratedAt;
    }

    public function setCratedAt(\DateTimeInterface$cratedAt): self
    {
        $this->cratedAt = $cratedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface$updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    /**
     * @return Collection|Page[]
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(Page $page): self
    {
        if (!$this->pages->contains($page)) {
            $this->pages[] = $page;
            $page->setChapter($this);
        }

        return $this;
    }

    public function removePage(Page $page): self
    {
        if ($this->pages->removeElement($page)) {
            // set the owning side to null (unless already changed)
            if ($page->getChapter() === $this) {
                $page->setChapter(null);
            }
        }

        return $this;
    }

    public function getParentChapter(): ?self
    {
        return $this->parentChapter;
    }

    public function setParentChapter(?self $parentChapter): self
    {
        $this->parentChapter = $parentChapter;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChapter(): Collection
    {
        return $this->chapter;
    }

    public function addChapter(self $chapter): self
    {
        if (!$this->chapter->contains($chapter)) {
            $this->chapter[] = $chapter;
            $chapter->setParentChapter($this);
        }

        return $this;
    }

    public function removeChapter(self $chapter): self
    {
        if ($this->chapter->removeElement($chapter)) {
            // set the owning side to null (unless already changed)
            if ($chapter->getParentChapter() === $this) {
                $chapter->setParentChapter(null);
            }
        }

        return $this;
    }
}