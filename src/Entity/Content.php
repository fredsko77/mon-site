<?php

namespace App\Entity;

use App\Repository\ContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=ContentBloc::class, mappedBy="content", cascade={"persist", "remove"})
     */
    private $blocs;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="contents")
     */
    private $user;

    public function __construct()
    {
        $this->blocs = new ArrayCollection();
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

    /**
     * @return Collection|ContentBloc[]
     */
    public function getBlocs(): Collection
    {
        return $this->blocs;
    }

    public function addBloc(ContentBloc $bloc): self
    {
        if (!$this->blocs->contains($bloc)) {
            $this->blocs[] = $bloc;
            $bloc->setContent($this);
        }

        return $this;
    }

    public function removeBloc(ContentBloc $bloc): self
    {
        if ($this->blocs->removeElement($bloc)) {
            // set the owning side to null (unless already changed)
            if ($bloc->getContent() === $this) {
                $bloc->setContent(null);
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
}
