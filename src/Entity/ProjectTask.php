<?php

namespace App\Entity;

use App\Repository\ProjectTaskRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProjectTaskRepository::class)
 */
class ProjectTask
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"project:read", "task:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom est obligatoire !")
     * @Groups({"project:read", "task:read"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="tasks")
     */
    private $project;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"project:read", "task:read"})
     */
    private $ref;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(?string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }
}
