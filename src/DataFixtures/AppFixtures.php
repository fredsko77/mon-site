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
        $admin = new User;
        $admin->setFirstname('Frédérick')
            ->setLastname('AGATHE')
            ->setUsername('admin')
            ->setEmail('admin@agathefrederick.fr')
            ->setPassword($this->hasher->hashPassword($admin, 'admin123!'))
            ->setRoles(['ROLE_ADMIN'])
            ->setConfirm(true)
            ->setCreatedAt(new DateTime('now'))
        ;

        $manager->persist($admin);

        $user = new User;
        $user->setFirstname('Frédérick')
            ->setLastname('AGATHE')
            ->setUsername('fagathe7')
            ->setEmail('user@agathefrederick.fr')
            ->setPassword($this->hasher->hashPassword($user, 'user123!'))
            ->setRoles(['ROLE_USER'])
            ->setConfirm(true)
            ->setCreatedAt(new DateTime('now'))
        ;

        $manager->persist($user);

        $manager->flush();
    }
}
