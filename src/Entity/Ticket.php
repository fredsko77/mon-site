<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TicketRepository::class)
 */
class Ticket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $ref;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $priority;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $estimation;

    /**
     * @ORM\OneToMany(targetEntity=TicketComment::class, mappedBy="ticket", cascade={"persist", "remove"})
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tickets")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=TicketDocument::class, mappedBy="ticket", cascade={"persist", "remove"})
     */
    private $docs;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->docs = new ArrayCollection();
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(?string $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getEstimation(): ?float
    {
        return $this->estimation;
    }

    public function setEstimation(?float $estimation): self
    {
        $this->estimation = $estimation;

        return $this;
    }

    /**
     * @return Collection|TicketComment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(TicketComment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTicket($this);
        }

        return $this;
    }

    public function removeComment(TicketComment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTicket() === $this) {
                $comment->setTicket(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|TicketDocument[]
     */
    public function getDocs(): Collection
    {
        return $this->docs;
    }

    public function addDoc(TicketDocument $doc): self
    {
        if (!$this->docs->contains($doc)) {
            $this->docs[] = $doc;
            $doc->setTicket($this);
        }

        return $this;
    }

    public function removeDoc(TicketDocument $doc): self
    {
        if ($this->docs->removeElement($doc)) {
            // set the owning side to null (unless already changed)
            if ($doc->getTicket() === $this) {
                $doc->setTicket(null);
            }
        }

        return $this;
    }
}
