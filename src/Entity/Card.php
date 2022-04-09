<?php

namespace App\Entity;

use App\Repository\CardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CardRepository::class)
 */
class Card
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
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $state;

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
     * @ORM\ManyToOne(targetEntity=Board::class, inversedBy="cards")
     */
    private $board;

    /**
     * @ORM\OneToMany(targetEntity=CardFile::class, mappedBy="card", cascade={"persist", "remove"})
     */
    private $files;

    /**
     * @ORM\OneToMany(targetEntity=CardNote::class, mappedBy="card", cascade={"persist", "remove"})
     */
    private $notes;

    /**
     * @ORM\OneToMany(targetEntity=Checklist::class, mappedBy="card", cascade={"persist", "remove"})
     */
    private $tasks;

    /**
     * @ORM\OneToMany(targetEntity=CardSource::class, mappedBy="card", cascade={"persist", "remove"})
     */
    private $sources;

    /**
     * @ORM\ManyToMany(targetEntity=BoardTag::class, mappedBy="cards", cascade={"persist", "remove"})
     */
    private $tags;

    /**
     * Card states
     */
    public const STATE_NEW = 'new';
    public const STATE_TODO = 'to-do';
    public const STATE_INPROGRESS = 'in-progress';
    public const STATE_TOVALIDATE = 'to-validate';
    public const STATE_DONE = 'done';
    public const STATE_CLOSED = 'closed';

    public function __construct()
    {
        $this->files = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->sources = new ArrayCollection();
        $this->tags = new ArrayCollection();
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

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(?\DateTimeInterface $deadline): self
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getBoard(): ?Board
    {
        return $this->board;
    }

    public function setBoard(?Board $board): self
    {
        $this->board = $board;

        return $this;
    }

    /**
     * @return Collection|CardFile[]
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(CardFile $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
            $file->setCard($this);
        }

        return $this;
    }

    public function removeFile(CardFile $file): self
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getCard() === $this) {
                $file->setCard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CardNote[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(CardNote $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setCard($this);
        }

        return $this;
    }

    public function removeNote(CardNote $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getCard() === $this) {
                $note->setCard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Checklist[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Checklist $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setCard($this);
        }

        return $this;
    }

    public function removeTask(Checklist $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getCard() === $this) {
                $task->setCard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CardSource[]
     */
    public function getSources(): Collection
    {
        return $this->sources;
    }

    public function addSource(CardSource $source): self
    {
        if (!$this->sources->contains($source)) {
            $this->sources[] = $source;
            $source->setCard($this);
        }

        return $this;
    }

    public function removeSource(CardSource $source): self
    {
        if ($this->sources->removeElement($source)) {
            // set the owning side to null (unless already changed)
            if ($source->getCard() === $this) {
                $source->setCard(null);
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
            $tag->addCard($this);
        }

        return $this;
    }

    public function removeTag(BoardTag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeCard($this);
        }

        return $this;
    }

    /**
     * Return an array of states
     *
     * @return array
     */
    public static function getStates():array {
        return [
            self::STATE_NEW,
            self::STATE_TODO,
            self::STATE_INPROGRESS,
            self::STATE_TOVALIDATE,
            self::STATE_DONE,
            self::STATE_CLOSED,
        ];
    }
}
