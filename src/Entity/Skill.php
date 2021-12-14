<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SkillRepository::class)
 */
class Skill
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=GroupSkil::class, inversedBy="skills")
     */
    private $groupSkill;

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

    public function getGroupSkill(): ?GroupSkil
    {
        return $this->groupSkill;
    }

    public function setGroupSkill(?GroupSkil $groupSkill): self
    {
        $this->groupSkill = $groupSkill;

        return $this;
    }
}
