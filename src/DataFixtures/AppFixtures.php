<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    /**
     * @var UserPasswordHasherInterface $hasher
     */
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User;
        $user->setFirstname('Frédérick')
            ->setLastname('AGATHE')
            ->setUsername('fagathe')
            ->setEmail('fagathe77@gmail.com')
            ->setPassword($this->hasher->hashPassword($user, '1995Posse'))
            ->setRoles(['ROLE_ADMIN'])
            ->setConfirm(true)
            ->setCreatedAt(new DateTime('now'))
        ;

        $manager->persist($user);

        $manager->flush();
    }
}
