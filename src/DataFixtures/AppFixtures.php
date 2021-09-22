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
        $user1 = new User;
        $user1->setFirstname('toto')
            ->setLastname('toto')
            ->setUsername('toto')
            ->setEmail('toto1@mail.fr')
            ->setPassword($this->hasher->hashPassword($user1, 'toto1'))
            ->setRoles(['ROLE_USER'])
            ->setConfirm(true)
            ->setToken('token_user_1')
            ->setCreatedAt(new DateTime('now'))
        ;

        $manager->persist($user1);

        $user2 = new User;
        $user2->setFirstname('toto')
            ->setLastname('toto')
            ->setUsername('toto')
            ->setEmail('toto2@mail.fr')
            ->setPassword($this->hasher->hashPassword($user2, 'toto2'))
            ->setRoles(['ROLE_USER'])
            ->setConfirm(false)
            ->setToken('token_user_2')
            ->setCreatedAt(new DateTime('now'))
        ;

        $manager->persist($user2);

        $manager->flush();
    }
}
