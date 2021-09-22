<?php

namespace App\Entity;

use App\Repository\TicketCommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TicketCommentRepository::class)
 */
class TicketComment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=Ticket::class, inversedBy="comments")
     */
    private $ticket;

    /**
     * @ORM\OneToMany(targetEntity=TicketCommentDocument::class, mappedBy="ticket", cascade={"persist", "remove"})
     */
    private $commentDocuments;

    public function __construct()
    {
        $this->commentDocuments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function setTicket(?Ticket $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * @return Collection|TicketCommentDocument[]
     */
    public function getCommentDocuments(): Collection
    {
        return $this->commentDocuments;
    }

    public function addCommentDocument(TicketCommentDocument $commentDocument): self
    {
        if (!$this->commentDocuments->contains($commentDocument)) {
            $this->commentDocuments[] = $commentDocument;
            $commentDocument->setTicket($this);
        }

        return $this;
    }

    public function removeCommentDocument(TicketCommentDocument $commentDocument): self
    {
        if ($this->commentDocuments->removeElement($commentDocument)) {
            // set the owning side to null (unless already changed)
            if ($commentDocument->getTicket() === $this) {
                $commentDocument->setTicket(null);
            }
        }

        return $this;
    }
}
