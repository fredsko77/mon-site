<?php
namespace App\Services\Admin;

use App\Entity\User;
use App\Utils\ServicesTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProfileServices implements ProfileServicesInterface
{

    use ServicesTrait;

    /**
     * @var ValidatorInterface $validator
     */
    private $validator;

    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    /**
     * @var SerializerInterface $serializer
     */
    private $serializer;

    /**
     * @var UserPasswordHasherInterface $hasher
     */
    private $hasher;

    public function __construct(ValidatorInterface $validator, EntityManagerInterface $manager, SerializerInterface $serializer, UserPasswordHasherInterface $hasher)
    {
        $this->validator = $validator;
        $this->manager = $manager;
        $this->serializer = $serializer;
        $this->hasher = $hasher;
    }

    public function changePassword(Request $request, User $user): object
    {
        $data = $request->getContent();
        $user = $this->serializer->deserialize($data, User::class, 'json', ['object_to_populate' => $user]);

        $errors = $this->filterViolations($this->validator->validate($user));

        if (count($errors) > 0) {
            return $this->sendViolations($errors);
        }

        $this->manager->persist($user);
        $this->manager->flush();

        return $this->sendJson($user);
    }

    public function deleteImage(User $user): object
    {
        return $this->sendJson();
    }

    public function edit(Request $request, User $user): object
    {
        $data = $request->getContent();
        $user = $this->serializer->deserialize($data, User::class, 'json', ['object_to_populate' => $user]);

        $errors = $this->filterViolations($this->validator->validate($user));

        if (count($errors) > 0) {
            return $this->sendViolations($errors);
        }

        $this->manager->persist($user);
        $this->manager->flush();

        return $this->sendJson($user);
    }

    public function uploadImage(Request $request, User $user): object
    {
        return $this->sendJson();
    }

}
