<?php

namespace App\Entity;

use App\Repository\ProjectImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProjectImageRepository::class)
 */
class ProjectImage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"project:read"})
     * @Groups({"image:read", "project:read"})
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"project:read", "image:read"})
     */
    private $original_name;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"project:read", "image:read"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"image:read"})
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="images")
     */
    private $project;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"project:read", "image:read"})
     */
    private $is_main;

    /**
     * @ORM\Column(type="string", length=150)
     * @Groups({"project:read", "image:read"})
     */
    private $ref;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getOriginalName(): ?string
    {
        return $this->original_name;
    }

    public function setOriginalName(string $original_name): self
    {
        $this->original_name = $original_name;

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

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getIsMain(): ?bool
    {
        return $this->is_main;
    }

    public function setIsMain(?bool $is_main): self
    {
        $this->is_main = $is_main;

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
}
