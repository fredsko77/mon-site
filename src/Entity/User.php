<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     fields={"email"},
 *     errorPath="email",
 *     message="Cette adresse email est déjà utilisée !"
 * )
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(message="Cette adresse email n'est pas valide !")
     * @Assert\NotBlank(message="L'adresse email est obligatoire !")
     * @Groups({"user:read"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"user:read"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Regex(
     *  pattern="#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])#",
     *  match="true",
     *  message="Le mot de passe doit contenir au moins une masjuscule, une minuscule et un chiffre."
     * )
     * @Assert\Length(min=8, minMessage="Le mot de passe doit contenir au moins 8 caractères!")
     * @Assert\NotBlank(message="Le mot de passe est obligatoire !")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\NotBlank(message="Le nom d'utilisateur est obligatoire!", allowNull=true)
     * @Groups({"user:read"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\NotBlank(message="Le prénom est obligatoire !", allowNull=true)
     * @Groups({"user:read"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\NotBlank(message="Le nom de famille est obligatoire !", allowNull=true)
     * @Groups({"user:read"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user:read"})
     */
    private $token;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\NotBlank(message="Le numéro de téléphone est obligatoire !", allowNull=true)
     * @Groups({"user:read"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Groups({"user:read"})
     */
    private $uid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resume;

    /**
     * @ORM\OneToOne(targetEntity=Content::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $content;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get the value of username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function setUid(string $uid): self
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get the value of token
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */
    public function setToken(?string $token): self
    {
        $this->token = $token;

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

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(?string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getContent(): ?Content
    {
        return $this->content;
    }

    public function setContent(?Content $content): self
    {
        // unset the owning side of the relation if necessary
        if ($content === null && $this->content !== null) {
            $this->content->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($content !== null && $content->getUser() !== $this) {
            $content->setUser($this);
        }

        $this->content = $content;

        return $this;
    }

}
