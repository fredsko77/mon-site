<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Chapter;
use App\Entity\Contact;
use App\Entity\GroupSkill;
use App\Entity\Page;
use App\Entity\Project;
use App\Entity\Shelf;
use App\Entity\Skill;
use App\Entity\Social;
use App\Entity\Stack;
use App\Entity\User;
use App\Utils\FakerTrait;
use App\Utils\ServicesTrait;
use Cocur\Slugify\Slugify;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DocsFixtures extends Fixture
{
    use FakerTrait;

    /**
     * @var Slugify $slugger
     */
    private $slugger;

    public function __construct()
    {
        $this->slugger = new Slugify;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i <= random_int(25, 40); $i++) {
            $shelf = new Shelf;

            $shelf->setTitle($faker->words(random_int(1, 3), true))
                ->setDescription($faker->sentences(random_int(1, 2), true))
                ->setImage($faker->imageUrl())
                ->setSlug($this->slugger->slugify($shelf->getTitle()))
                ->setCreatedAt($faker->dateTimeBetween('-4 years', '-1 year'))
                ->setUpdatedAt($this->setDateTimeAfter($shelf->getCreatedAt()))
                ->setVisibility($i % 19 === 0 ? Shelf::VISIBILITY_PRIVATE : Shelf::VISIBILITY_PUBLIC)
            ;

            for ($b = 0; $b <= random_int(15, 25); $b++) {
                $book = new Book;

                $book->setTitle($faker->words(random_int(1, 3), true))
                    ->setDescription($faker->sentences(random_int(1, 2), true))
                    ->setSlug($this->slugger->slugify($shelf->getTitle()))
                    ->setCreatedAt($this->setDateTimeAfter($shelf->getCreatedAt()))
                    ->setUpdatedAt($this->setDateTimeAfter($book->getCreatedAt()))
                    ->setVisibility($b % 8 === 0 ? Book::VISIBILITY_PRIVATE : Book::VISIBILITY_PUBLIC)
                ;

                for ($c = 0; $c <= random_int(8, 15); $c++) {
                    $chapter = new Chapter;

                    $chapter->setTitle($faker->words(random_int(1, 3), true))
                        ->setDescription($faker->sentences(random_int(1, 2), true))
                        ->setSlug($this->slugger->slugify($shelf->getTitle()))
                        ->setCreatedAt($this->setDateTimeAfter($book->getCreatedAt()))
                        ->setUpdatedAt($this->setDateTimeAfter($chapter->getCreatedAt()))
                        ->setVisibility($c % 15 === 0 ? Chapter::VISIBILITY_PRIVATE : Chapter::VISIBILITY_PUBLIC)
                    ;

                    for ($p = 0; $p <= random_int(5, 12); $p++) {
                        $page = new Page;
                        $page->setTitle($faker->words(random_int(1, 6), true))
                            ->setSlug($this->slugger->slugify($page->getTitle()))
                            ->setContent($this->setPageContent())
                            ->setVisibility($p % 10 === 0 ? Page::VISIBILITY_PRIVATE : Page::VISIBILITY_PUBLIC)
                            ->setState($p % 8 === 0 ? Page::STATE_PENDING : Page::STATE_PUBLISHED)
                            ->setCreatedAt($this->setDateTimeAfter($chapter->getCreatedAt()))
                            ->setUpdatedAt($this->setDateTimeAfter($page->getCreatedAt()))
                        ;

                        $chapter->addPage($page);
                    }

                    $book->addChapter($chapter);
                }

                for ($p = 0; $p <= random_int(5, 8); $p++) {
                    $page = new Page;
                    $page->setTitle($faker->words(random_int(1, 6), true))
                        ->setSlug($this->slugger->slugify($page->getTitle()))
                        ->setContent($this->setPageContent())
                        ->setVisibility($p % 8 === 0 ? Page::VISIBILITY_PRIVATE : Page::VISIBILITY_PUBLIC)
                        ->setState($p % 8 === 0 ? Page::STATE_PENDING : Page::STATE_PUBLISHED)
                        ->setCreatedAt($this->setDateTimeAfter($chapter->getCreatedAt()))
                        ->setUpdatedAt($this->setDateTimeAfter($page->getCreatedAt()))
                    ;

                    $book->addPage($page);
                }

                $shelf->addBook($book);
            }

            $manager->persist($shelf);
        }

        $manager->flush();
    }   
}
