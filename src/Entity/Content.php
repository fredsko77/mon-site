<?php

namespace App\Entity;

use App\Repository\ContentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ContentRepository::class)
 */
class Content
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"content:read"})
     */
    private $heading_primary;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"content:read"})
     */
    private $heading_secondary;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @Groups({"content:read"})
     */
    private $biography_blocs = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"content:read"})
     */
    private $footing_primary;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"content:read"})
     */
    private $footing_secondary;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"content:read"})
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"content:read"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"content:read"})
     */
    private $updated_at;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="content", cascade={"persist", "remove"})
     */
    private $user;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeadingPrimary(): ?string
    {
        return $this->heading_primary;
    }

    public function setHeadingPrimary(string $heading_primary): self
    {
        $this->heading_primary = $heading_primary;

        return $this;
    }

    public function getHeadingSecondary(): ?string
    {
        return $this->heading_secondary;
    }

    public function setHeadingSecondary(?string $heading_secondary): self
    {
        $this->heading_secondary = $heading_secondary;

        return $this;
    }

    public function getBiographyBlocs(): ?array
    {
        return $this->biography_blocs;
    }

    public function setBiographyBlocs(?array $biography_blocs): self
    {
        $this->biography_blocs = $biography_blocs;

        return $this;
    }

    public function getFootingPrimary(): ?string
    {
        return $this->footing_primary;
    }

    public function setFootingPrimary(?string $footing_primary): self
    {
        $this->footing_primary = $footing_primary;

        return $this;
    }

    public function getFootingSecondary(): ?string
    {
        return $this->footing_secondary;
    }

    public function setFootingSecondary(?string $footing_secondary): self
    {
        $this->footing_secondary = $footing_secondary;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
