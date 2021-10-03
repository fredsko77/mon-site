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
        $admin->setUsername('admin')
            ->setEmail('admin@admin.fr')
            ->setPassword($this->hasher->hashPassword($admin, 'admin123!'))
            ->setRoles(['ROLE_ADMIN'])
            ->setCreatedAt(new DateTime('now'))
            ->setUid(uniqid('user'))
        ;

        $manager->persist($admin);

        $user = new User;
        $user->setFirstname('Frédérick')
            ->setLastname('AGATHE')
            ->setUsername('fagathe77')
            ->setEmail('fagathe77@gmail.com')
            ->setPassword($this->hasher->hashPassword($user, 'user123!'))
            ->setRoles(['ROLE_USER'])
            ->setCreatedAt(new DateTime('now'))
            ->setUid(uniqid('user'))
        ;

        $manager->persist($user);

        $manager->flush();
    }
}
