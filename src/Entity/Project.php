<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank(message="Le nom ne peut pas être nul !")
     * @Groups({"project:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url(message="Cette url n'est pas valide !")
     * @Groups({"project:read"})
     */
    private $link;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank(message="Ce champs est obligatoire !", allowNull=true)
     * @Groups({"project:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\NotBlank(message="Ce champs est obligatoire !", allowNull=true)
     * @Groups({"project:read"})
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champs est obligatoire !", allowNull=true)
     * @Groups({"project:read"})
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"project:read"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"project:read"})
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=ProjectTask::class, mappedBy="project", cascade={"persist", "remove"})
     * @Groups({"project:read"})
     */
    private $tasks;

    /**
     * @ORM\OneToMany(targetEntity=ProjectImage::class, mappedBy="project", cascade={"persist", "remove"})
     * @Groups({"project:read"})
     */
    private $images;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     * @Groups({"project:read"})
     */
    private $visibility;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $stack = [];

    public const STATE_DEVELOPMENT = "en-developpement";
    public const STATE_STABLE = "stable";
    public const STATE_ACHIEVED = "termine";

    public const VISIBILITY_PUBLIC = 'publique';
    public const VISIBILITY_PRIVATE = 'privee';

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

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

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

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

    /**
     * @return Collection|ProjectTask[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(ProjectTask $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setProject($this);
        }

        return $this;
    }

    public function removeTask(ProjectTask $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getProject() === $this) {
                $task->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return ProjectImage[]
     */
    public function getProjectImages()
    {
        $images = $this->images->toArray();
        foreach ($this->images as $key => $image) {
            if ($image->getIsMain() && $key !== 0) {
                $replacements = [
                    0 => $images[$key],
                    $key => $images[0],
                ];
                $images = array_replace($images, $replacements);
            }
        }
        return $images;
    }

    /**
     * @return Collection|ProjectImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(ProjectImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setProject($this);
        }

        return $this;
    }

    public function removeImage(ProjectImage $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProject() === $this) {
                $image->setProject(null);
            }
        }

        return $this;
    }

    public function getVisibility(): ?string
    {
        return $this->visibility;
    }

    public function setVisibility(?string $visibility): self
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * @return array
     */
    public static function states(): array
    {
        return [
            self::STATE_DEVELOPMENT => 'En développement',
            self::STATE_STABLE => 'Stable',
            self::STATE_ACHIEVED => 'Achevé',
        ];
    }

    /**
     *@return array
     */
    public static function visibilities(): array
    {
        return [
            self::VISIBILITY_PRIVATE => 'Privée',
            self::VISIBILITY_PUBLIC => 'Publique',
        ];
    }

    public function getStack(): ?array
    {
        return $this->stack;
    }

    public function setStack(?array $stack): self
    {
        $this->stack = $stack;

        return $this;
    }
}
