<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Card;
use App\Entity\User;
use App\Entity\Board;
use App\Entity\Skill;
use App\Entity\Stack;
use App\Entity\Social;
use App\Entity\Contact;
use App\Entity\Project;
use App\Entity\BoardTag;
use App\Entity\CardFile;
use App\Entity\CardNote;
use App\Entity\FileType;
use App\Entity\BoardType;
use App\Entity\Checklist;
use App\Utils\FakerTrait;
use App\Entity\CardSource;
use App\Entity\GroupSkill;
use Cocur\Slugify\Slugify;
use App\Utils\ServicesTrait;
use App\Entity\FileExtension;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture
{

    use FakerTrait, ServicesTrait;

    /**
     * @var UserPasswordHasherInterface $hasher
     */
    private $hasher;

    /**
     * @var Slugify $slugger
     */
    private $slugger;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;    
        $this->slugger = new Slugify;    
    }

    /**
     * @param ObjectManager $manager
     * 
     * @return void
     */
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        $stacks = [];

        foreach ($this->getStacks() as $key => $name) {
            $stack = new Stack;
            $stack->setName($name);
            $stacks[] = $stack;

            $manager->persist($stack);
        }

        foreach ($this->getGroupSkills() as $k => $group) {
            $groupskill = new GroupSkill;
            $groupskill->setName($group['name'])
                ->setIcon($group['icon'])
                ->setColor($group['color'])
                ->setCreatedAt($this->now())
            ;

            foreach ($group['skills'] as $key => $name) {
                $skill = new Skill;
                $skill->setName($name);
                $groupskill->addSkill($skill);
            }

            $manager->persist($groupskill);
        }

        foreach ($this->getSocials() as $social) {
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
            ->setConfirm(true)
        ;

        $manager->persist($admin);

        $user = new User;
        $user->setUsername('fagathe')
            ->setEmail('fagathe77@gmail.com')
            ->setPassword($this->hasher->hashPassword($user, 'Password123!'))
            ->setRoles(['ROLE_USER'])
            ->setCreatedAt(new DateTime('now'))
            ->setUpdatedAt(new DateTime('now'))
            ->setToken(null)
            ->setConfirm(true)
        ;

        $manager->persist($user);

        for ($u = 0; $u < random_int(25, 100); $u++) {
            $user = new User;
            $user->setUsername($faker->userName())
                ->setImage($faker->imageUrl())
                ->setEmail($faker->email())
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setPassword($this->hasher->hashPassword($user, 'Password123!'))
                ->setRoles($u % 50 ? ['ROLE_ADMIN'] : ['ROLE_USER'])
                ->setCreatedAt($faker->dateTimeBetween('-4 years', '-1 year'))
                ->setUpdatedAt($this->setDateTimeAfter($user->getCreatedAt()))
                ->setToken(null)
                ->setSlug($this->slugger->slugify($user->getFirstname() . ' ' . $user->getLastname()))
                ->setConfirm($u % 190 === 0 ? true : false)
                ->setBiography($faker->sentences(random_int(3, 6), true))
            ;

            $manager->persist($user);
        }

        for ($p = 0; $p <= random_int(10, 50); $p++) {
            $project = new Project;
            $projectStacks = $this->selectRandomArrayElements($stacks);

            $project->setName($faker->words(1, 6))
                ->setLink($faker->url())
                ->setDescription($faker->sentences(random_int(2, 6), true))
                ->setState($faker->randomElement([
                    Project::STATE_DEVELOPMENT,
                    Project::STATE_STABLE,
                    Project::STATE_ACHIEVED,
                ]))
                ->setSlug($this->slugger->slugify($project->getName()))
                ->setImage($faker->imageUrl())
                ->setVisibility($p % 15 === 0 ? Project::VISIBILITY_PRIVATE : Project::VISIBILITY_PUBLIC)
                ->setTasks($this->selectRandomArrayElements($this->getProjectTasks(), random_int(3, 8)))
                ->setCreatedAt($faker->dateTimeBetween('-4 years', '-1 year'))
                ->setUpdatedAt($this->setDateTimeAfter($project->getCreatedAt()))
            ;

            foreach ($projectStacks as $key => $stack) {
                $project->addStack($stack);
            }

            $manager->persist($project);
        }

        for ($c = 0; $c < random_int(50, 100); $c++) {
            $contact = new Contact;

            $contact->setAbout($faker->words(random_int(3, 6), true))
                ->setEmail($faker->email())
                ->setFullname($faker->name())
                ->setCompanyName($c % 9 ? null : $faker->company())
                ->setTelephone($c % 9 ? $faker->phoneNumber() : null)
                ->setMessage("Bonjour monsieur AGATHE, \\n\\r" . $faker->sentences(random_int(3, 10), true) . "\\n\\r Bien ordialement,\\n\\r " . $contact->getFullname())
                ->setState($faker->randomElement([
                    Contact::STATE_PENDING,
                    Contact::STATE_READ,
                    Contact::STATE_REPLIED,
                ]))
                ->setCreatedAt($faker->dateTimeBetween('-4 years', '-1 year'))
                ->setUpdatedAt($contact->getState() !== Contact::STATE_PENDING ? $this->setDateTimeAfter($contact->getCreatedAt()) : null)
                ->setRepliedAt($contact->getState() === Contact::STATE_REPLIED ? $this->setDateTimeAfter($contact->getCreatedAt()) : null)
            ;

            $manager->persist($contact);
        }


        $manager->flush();
    }

    private function getProjectTasks(): array
    {
        // Project Tasks
        return [
            'Rédiger une documentation à l\'intention d\'utilisateurs non spécialistes',
            'Sélectionner un thème Wordpress adapté aux besoins du client',
            'Adapter un thème Wordpress pour respecter les exigences du client',
            'Lister les fonctionnalités demandées par un client',
            'Analyser un cahier des charges',
            'Rédiger les spécifications détaillées du projet',
            'Choisir une solution technique adaptée parmi les solutions existantes si cela est pertinent',
            'Concevoir l\'architecture technique d\'une application à l\'aide de diagrammes UML',
            'Implémenter le schéma de données dans la base',
            'Réaliser un schéma de conception de la base de données de l\'application',
            'Réaliser des schémas UML cohérents et en accord avec les besoins énoncés',
            'Proposer un code propre et facilement évolutif',
            'Assurer le suivi qualité d\'un projet',
            'Rédiger les spécifications détaillées du projet',
            'Créer une page web permettant de recueillir les informations saisies par un internaute',
            'Estimer une tâche et tenir les délais',
            'Analyser un cahier des charges',
            'Créer et maintenir l\'architecture technique du site',
            'Choisir une solution technique adaptée parmi les solutions existantes si cela est pertinent',
            'Gérer ses données avec une base de données',
            'Conceptualiser l\'ensemble de son application en décrivant sa structure (Entités / Domain Objects)',
            'Prendre en main le framework Symfony',
            'Développer une application proposant les fonctionnalités attendues par le client',
            'Gérer une base de données MySQL ou NoSQL avec Doctrine',
            'Organiser son code pour garantir la lisibilité et la maintenabilité',
            'Prendre en main le moteur de templating Twig',
            'Respecter les bonnes pratiques de développement en vigueur',
            'Sélectionner les langages de programmation adaptés pour le développement de l\'application',
            'Concevoir une architecture efficace et adaptée',
            'Analyser et optimiser les performances d\'une application',
            'Produire une documentation technique',
            'Suivre la qualité d\'un projet',
            'Exposer une API REST avec Symfony',
            'Lancer une authentification à chaque requête HTTP',
            'Mettre en œuvre des tests unitaires et fonctionnels',
            'Implémenter de nouvelles fonctionnalités au sein d\'une application déjà initiée en suivant un plan de collaboration clair',
            'Lire et retranscrire le fonctionnement d\'un morceau de code écrit par d\'autres développeurs',
            'Produire un rapport de l\'exécution des tests',
            'Analyser la qualité de code et la performance d\'une application',
            'Établir un plan pour réduire la dette technique d\'une application',
            'Fournir des patchs correctifs lorsque les tests le suggèrent',
            'Proposer une série d\'améliorations',
        ];
    }
    
    /**
     * @return array
     */
    private function getGroupSkills(): array
    {

        // GroupSkills
        return [
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
    }

    /**
     * @return array
     */
    private function getSocials(): array
    {
        // Socials
        return [
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
    }

    /**
     * @return array
     */
    private function getStacks(): array
    {
        // Stacks
        return [
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
    }
}
