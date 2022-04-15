<?php

namespace App\Entity;

use App\Repository\BoardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BoardRepository::class)
 */
class Board
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=BoardType::class, inversedBy="boards")
     */
    private $type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deadline;

    /**
     * @ORM\OneToMany(targetEntity=Card::class, mappedBy="board", cascade={"persist", "remove"})
     */
    private $cards;

    /**
     * @ORM\OneToMany(targetEntity=BoardTag::class, mappedBy="board", cascade={"persist", "remove"})
     */
    private $tags;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default":"0"})
     */
    private $isBookmarked;

    /**
     * @ORM\OneToMany(targetEntity=BoardList::class, mappedBy="board", cascade={"persist", "remove"})
     */
    private $lists;

    /**
     * @ORM\Column(type="boolean", nullable="false", options={"dafault": "0"})
     */
    private $isOpen;

    /**
     * Board states
     */
    public const STATE_OPEN = 'open';
    public const STATE_CLOSED = 'closed';

    public function __construct()
    {
        $this->cards = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->lists = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?BoardType
    {
        return $this->type;
    }

    public function setType(?BoardType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface$createdAt): self
    {
        $this->createdAt = $createdAt;

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

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(?\DateTimeInterface$deadline): self
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * @return Collection|Card[]
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
            $card->setBoard($this);
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->cards->removeElement($card)) {
            // set the owning side to null (unless already changed)
            if ($card->getBoard() === $this) {
                $card->setBoard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BoardTag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(BoardTag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->setBoard($this);
        }

        return $this;
    }

    public function removeTag(BoardTag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            // set the owning side to null (unless already changed)
            if ($tag->getBoard() === $this) {
                $tag->setBoard(null);
            }
        }

        return $this;
    }

    public function getIsBookmarked(): ?bool
    {
        return $this->isBookmarked;
    }

    public function setIsBookmarked(bool $isBookmarked): self
    {
        $this->isBookmarked = $isBookmarked;

        return $this;
    }

    /**
     * @return Collection|BoardList[]
     */
    public function getLists(): Collection
    {
        return $this->lists;
    }

    public function addList(BoardList $list): self
    {
        if (!$this->lists->contains($list)) {
            $this->lists[] = $list;
            $list->setBoard($this);
        }

        return $this;
    }

    public function removeList(BoardList $list): self
    {
        if ($this->lists->removeElement($list)) {
            // set the owning side to null (unless already changed)
            if ($list->getBoard() === $this) {
                $list->setBoard(null);
            }
        }

        return $this;
    }

    public function getIsOpen()
    {
        return $this->isOpen;
    }

    public function setIsOpen($isOpen)
    {
        $this->isOpen = $isOpen;

        return $this;
    }
}
