<?php

namespace App\DataFixtures;

use App\Entity\Stack;
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

        $stacks = [
            'PHP',
            'JavaScript',
            'CSS',
            'HTML',
            'Twig',
            'Symfony',
            'React js',
            'Bash',
            'Python',
            'WordPress',
            'Drupal',
            'Vue js',
            'Slim Framework',
            'Flask',
            'Laravel',
            'MySql',
        ];

        foreach ($stacks as $s) {
            $stack = new Stack;
            $stack->setName($s);

            $manager->persist($stack);
        }

        $admin = new User;
        $admin->setUsername('admin')
            ->setEmail('admin@admin.fr')
            ->setPassword($this->hasher->hashPassword($admin, 'Password123!'))
            ->setRoles(['ROLE_ADMIN'])
            ->setCreatedAt(new DateTime('now'))
            ->setUpdatedAt(new DateTime('now'))
            ->setToken(null)
            ->setSlug()
            ->setConfirm(true)
        ;

        $manager->persist($admin);

        $user = new User;
        $user->setFirstname('Frédérick')
            ->setLastname('AGATHE')
            ->setUsername('fagathe77')
            ->setEmail('fagathe77@gmail.com')
            ->setPassword($this->hasher->hashPassword($user, 'Password123!'))
            ->setRoles(['ROLE_USER'])
            ->setCreatedAt(new DateTime('now'))
            ->setUpdatedAt(new DateTime('now'))
            ->setToken(null)
            ->setSlug()
            ->setConfirm(true)
        ;

        $manager->persist($user);

        $manager->flush();
    }
}
