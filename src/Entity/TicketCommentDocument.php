<?php

namespace App\Entity;

use App\Repository\TicketCommentDocumentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TicketCommentDocumentRepository::class)
 */
class TicketCommentDocument
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
    private $original_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity=TicketComment::class, inversedBy="commentDocuments")
     */
    private $ticket;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginalName(): ?string
    {
        return $this->original_name;
    }

    public function setOriginalName(string $original_name): self
    {
        $this->original_name = $original_name;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getTicket(): ?TicketComment
    {
        return $this->ticket;
    }

    public function setTicket(?TicketComment $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }
}
