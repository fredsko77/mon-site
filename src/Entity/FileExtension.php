<?php

namespace App\Entity;

use App\Repository\FileExtensionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FileExtensionRepository::class)
 * @UniqueEntity
 *  fields={"name"},
 *  errorPath="name",
 *  message="Cette extension existe déjà !"
 * )
 */
class FileExtension
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank
     */
    private $extension;

    /**
     * @ORM\ManyToOne(targetEntity=FileType::class, inversedBy="fileExtensions")
     */
    private $fileType;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $icon;

    /**
     * @ORM\Column(type="boolean", nullable="false", options={"default": "0"})
     */
    private $hasIcon;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getFileType(): ?FileType
    {
        return $this->fileType;
    }

    public function setFileType(?FileType $fileType): self
    {
        $this->fileType = $fileType;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getHasIcon(): ?bool
    {
        return $this->hasIcon;
    }

    public function setHasIcon(bool $hasIcon): self
    {
        $this->hasIcon = $hasIcon;

        return $this;
    }
}
