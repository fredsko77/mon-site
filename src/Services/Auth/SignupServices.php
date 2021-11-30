<?php
namespace App\Services\Auth;

use App\Entity\User;
use App\Mailing\Auth\ConfirmationMailing;
use App\Repository\UserRepository;
use App\Services\Auth\SignupServicesInterface;
use App\Utils\ServicesTrait;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SignupServices implements SignupServicesInterface
{

    use ServicesTrait;

    /**
     * @var UserRepository $repository
     */
    private $repository;

    /**
     * @var ValidatorInterface $validator
     */
    private $validator;

    /**
     * @var SerializerInterface $serializer
     */
    private $serializer;

    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    /**
     * @var UrlGeneratorInterface $router
     */
    private $router;

    /**
     * @var ConfirmationMailing $mailing
     */
    private $mailing;

    /**
     * @var UserPasswordHasherInterface $hasher
     */
    private $hasher;

    /**
     * @var Slugify $slugger
     */
    private $slugger;

    public function __construct(
        UserRepository $repository,
        ValidatorInterface $validator,
        SerializerInterface $serializer,
        EntityManagerInterface $manager,
        UrlGeneratorInterface $router,
        ConfirmationMailing $mailing,
        UserPasswordHasherInterface $hasher
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->manager = $manager;
        $this->router = $router;
        $this->mailing = $mailing;
        $this->hasher = $hasher;
        $this->slugger = new Slugify;
    }

    /**
     * @param User $user
     *
     * @return object
     */
    public function store(User $user): void
    {
        $user
            ->setPassword($this->hasher->hashPassword($user, $user->getPassword()))
            ->setCreatedAt($this->now())
            ->setUsername($user->getUsername() ?? $this->generateUserName($user))
            ->setRoles(['ROLE_USER'])
            ->setConfirm(false)
            ->setSlug()
            ->setToken($this->generateTokenBase64($user))
        ;

        dd($user);

        $this->manager->persist($user);
        $this->manager->flush();

        $this->mailing->confirmEmail($user);

    }

}
