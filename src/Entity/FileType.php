<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FileTypeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=FileTypeRepository::class)
 * @UniqueEntity
 *  fields={"type"},
 *  errorPath="type",
 *  message="Ce type existe déjà !"
 * )
 */
class FileType
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
    private $name;
    
    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank 
     */
    private $icon;

    /**
     * @ORM\OneToMany(targetEntity=FileExtension::class, mappedBy="fileType", cascade={"persist", "remove"})
     */
    private $fileExtensions;

    public function __construct()
    {
        $this->fileExtensions = new ArrayCollection();
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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return Collection|FileExtension[]
     */
    public function getFileExtensions(): Collection
    {
        return $this->fileExtensions;
    }

    public function addFileExtension(FileExtension $fileExtension): self
    {
        if (!$this->fileExtensions->contains($fileExtension)) {
            $this->fileExtensions[] = $fileExtension;
            $fileExtension->setFileType($this);
        }

        return $this;
    }

    public function removeFileExtension(FileExtension $fileExtension): self
    {
        if ($this->fileExtensions->removeElement($fileExtension)) {
            // set the owning side to null (unless already changed)
            if ($fileExtension->getFileType() === $this) {
                $fileExtension->setFileType(null);
            }
        }

        return $this;
    }
}
