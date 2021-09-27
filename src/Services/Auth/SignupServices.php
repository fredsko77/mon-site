<?php
namespace App\Services\Auth;

use App\Entity\User;
use App\Mailing\Auth\ConfirmationMailing;
use App\Repository\UserRepository;
use App\Services\Auth\SignupServicesInterface;
use App\Utils\ServicesTrait;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    }

    /**
     * @param Request $request
     *
     * @return object
     */
    public function store(Request $request): object
    {
        $data = $request->getContent();
        $user = $this->serializer->deserialize($data, User::class, 'json');
        $slugify = new Slugify();
        $identifier = uniqid();

        $violations = $this->filterViolations($this->validator->validate($user));

        if ($this->repository->findOneBy(['username' => $user->getUsername()]) instanceof User) {
            $violations['username'] = 'Ce nom d\'utilisateur est déjà utilisé !';
        }

        if (count($violations) > 0) {
            return $this->sendViolations($violations);
        }

        $user
            ->setPassword($this->hasher->hashPassword($user, $user->getPassword()))
            ->setCreatedAt($this->now())
            ->setUsername($user->getUsername() ?? $this->generateUserName($user))
            ->setRoles(['ROLE_USER'])
            ->setConfirm(false)
            ->setUid($identifier)
            ->setSlug($slugify->slugify($user->getFirstname() . " " . $user->getLastname()))
            ->setToken($this->generateTokenBase64($user))
        ;

        $this->manager->persist($user);
        $this->manager->flush();

        $this->mailing->confirmEmail($user);

        return $this->sendJson(
            $user,
            Response::HTTP_CREATED,
            [
                'Location' => $this->router->generate('app_signin', [], UrlGenerator::ABSOLUTE_URL),
            ]
        );
    }

}
