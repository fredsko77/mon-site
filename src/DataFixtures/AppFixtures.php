<?php

namespace App\DataFixtures;

use App\Entity\GroupSkill;
use App\Entity\Skill;
use App\Entity\Social;
use App\Entity\Stack;
use App\Entity\User;
use App\Utils\ServicesTrait;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    use ServicesTrait;

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

        // Stack
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

        // GroupSkill
        $groupskills = [
            0 => [
                'name' => 'Front-end',
                'icon' => 'display',
                'color' => 'warning',
                'skills' => ['Html/Twig', 'Css/Bootstrap', 'Javascript/jQuery', 'VueJs'],
            ],
            1 => [
                'name' => 'Back-end',
                'icon' => 'cpu',
                'color' => 'crm',
                'skills' => ['PHP/POO/MVC', 'SQL/MySql', 'Slim Framework/Laravel', 'Zend Framework/Symfony', 'Ajax/Node'],
            ],
            2 => [
                'name' => 'Extra',
                'icon' => 'plus-square',
                'color' => 'success',
                'skills' => ['SEO', 'Gitlab', 'Composer', 'Debian 9'],
            ],
        ];

        foreach ($groupskills as $k => $group) {
            $groupskill = new GroupSkill;
            $groupskill->setName($group['name'])
                ->setIcon($group['icon'])
                ->setColor($group['color'])
                ->setCreatedAt($this->now())
            ;

            foreach ($group['skills'] as $k => $v) {
                $skill = new Skill;
                $skill->setName($v);

                $groupskill->addSkill($skill);
            }

            $manager->persist($groupskill);
        }

        $socials = [
            0 => [
                'name' => 'Linkedin',
                'link' => 'https://www.linkedin.com/in/frédérick-agathe-027553128/',
                'icon' => 'linkedin',
                'title' => 'Lien vers mon profil LinkedIn',
            ],
            1 => [
                'name' => 'Github',
                'link' => 'https://github.com/fredsko77',
                'icon' => 'github',
                'title' => 'Lien vers mon profil Github',
            ],
        ];

        foreach ($socials as $social) {
            $manager->persist(
                (new Social)
                    ->setName($social['name'])
                    ->setLink($social['link'])
                    ->setIcon($social['icon'])
                    ->setTitle($social['title'])
            );
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
