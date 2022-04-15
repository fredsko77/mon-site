<?php

namespace App\DataFixtures;

use App\Entity\Board;
use App\Entity\BoardTag;
use App\Entity\BoardType;
use App\Entity\Card;
use App\Entity\CardFile;
use App\Entity\CardNote;
use App\Entity\CardTask;
use App\Entity\FileExtension;
use App\Entity\FileType;
use App\Utils\FakerTrait;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BoardFixtures extends Fixture
{

    use FakerTrait;

    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        $fileTypes = [];

        foreach ($this->getFileTypes() as $key => $file_type) {
            $fileType = new FileType;
            $fileType
                ->setName($file_type['name'])
                ->setIcon($file_type['icon'])
            ;
            foreach ($file_type['extensions'] as $extensions) {
                $fileType->addFileExtension(
                    (new FileExtension)->setExtension($extensions)
                );
            }

            $manager->persist($fileType);

            $fileTypes[$key] = $fileType;
        }

        foreach ($this->getBoardTypes() as $key => $board_type) {
            $boardType = new BoardType();
            $boardType
                ->setName($board_type['name'])
                ->setIcon($board_type['icon'])
                ->setDescription($board_type['description'])
                ->setCreatedAt($faker->dateTimeBetween('-4 years', '-1 year'))
                ->setUpdatedAt($this->setDateTimeAfter($boardType->getCreatedAt()))
            ;

            for ($b = 0; $b < random_int(20, 50); $b++) {
                $board = new Board;

                $board
                    ->setName($faker->words(random_int(1, 3), true))
                    ->setDescription($faker->sentences(random_int(2, 6), true))
                    ->setCreatedAt($this->setDateTimeAfter($boardType->getCreatedAt()))
                    ->setUpdatedAt($this->setDateTimeAfter($board->getCreatedAt()))
                    ->setDeadline($this->setDateTimeAfter($board->getCreatedAt()))
                    ->setState($b % 4 ? Board::STATE_CLOSED : Board::STATE_OPEN)
                ;

                for ($bt = 0; $bt < random_int(9, 20); $bt++) {
                    $tag = new BoardTag;

                    $tag
                        ->setName($faker->words(random_int(1, 3), true))
                        ->setColor($faker->hexColor())
                        ->setDescription($faker->sentences(random_int(1, 2), true))
                    ;

                    $board->addTag($tag);
                }

                for ($bl = 0; $bl < random_int(3, 5); $bl++) {
                    # Ajouter des cartes ...
                }

                $tags = $board->getTags()->toArray();

                for ($c = 0; $c < random_int(40, 80); $c++) {
                    $card = new Card;

                    $card
                        ->setName($faker->words(random_int(1, 3), true))
                        ->setDescription($faker->sentences(random_int(2, 6), true))
                        ->setCreatedAt($this->setDateTimeAfter($board->getCreatedAt()))
                        ->setDeadline($this->setDateTimeAfter($card->getCreatedAt()))
                        ->setUpdatedAt($this->setDateTimeAfter($card->getCreatedAt()))
                    ;

                    for ($ct = 0; $ct < random_int(1, 3); $ct++) {
                        $card->addTag($faker->randomElement($tags));
                    }

                    for ($cn = 0; $cn < random_int(4, 8); $cn++) {
                        $note = new CardNote;

                        $note
                            ->setContent($faker->sentences(random_int(2, 6), true))
                            ->setCreatedAt($this->setDateTimeAfter($board->getCreatedAt()))
                            ->setUpdatedAt($this->setDateTimeAfter($note->getCreatedAt()))
                        ;

                        $card->addNote($note);
                    }

                    for ($cc = 0; $cc < random_int(2, 10); $cc++) {
                        $task = new CardTask;

                        $task
                            ->setTask($faker->words(random_int(1, 3), true))
                            ->setIsDone($cc % random_int(3, 6) ? false : true)
                            ->setCreatedAt($this->setDateTimeAfter($board->getCreatedAt()))
                        ;

                        $card->addTask($task);
                    }

                    for ($cf = 0; $cf < random_int(0, 2); $cf++) {
                        $file = new CardFile;

                        $file
                            ->setPath($faker->imageUrl(640, 480, 'animals', true, 'cats', true))
                            ->setOriginalName('image-' . $c . '-' . $cf . '.png')
                            ->setFileType($fileTypes[3])
                            ->setCreatedAt($this->setDateTimeAfter($card->getCreatedAt()))
                        ;

                        $card->addFile($file);
                    }

                    $board->addCard($card);
                }

                $boardType->addBoard($board);
            }

            $manager->persist($boardType);
        }

        $manager->flush();
    }

    /**
     * Return an array of board types
     *
     * @return array
     *
     */
    private function getBoardTypes(): array
    {
        return [
            [
                'name' => 'Site',
                'icon' => 'globe2',
                'description' => 'Tâches à faire sur le site',
            ],
            [
                'name' => 'Github',
                'icon' => 'github',
                'description' => 'Ticket Github',
            ],
            [
                'name' => 'Technique',
                'icon' => 'layers-fill',
                'description' => 'Contenu à ajouter sur la partie docs',
            ],
            [
                'name' => 'Autres',
                'icon' => 'journal',
                'description' => 'Autres',
            ],
            [
                'name' => 'Softia',
                'icon' => 'building',
                'description' => 'Contenu à ajouter sur la partie docs',
            ],
        ];
    }

    /**
     * Return an array of file types
     *
     * @return array
     */
    private function getFileTypes(): array
    {
        return [
            [
                'name' => 'Tableur',
                'icon' => 'file-spreadsheet',
                'extensions' => ['ods', 'xls', 'xlsx'],
            ],
            [
                'name' => 'Texte',
                'icon' => 'file-text',
                'extensions' => ['odt', 'doc', 'docx', 'txt'],
            ],
            [
                'name' => 'Code',
                'icon' => 'file-code',
                'extensions' => ['log', 'xml', 'twig', 'html', 'php', 'js', 'md', 'yaml', 'yml', 'json', '.env', 'css', 'sql', 'sh', 'py', 'htaccess'],
            ],
            [
                'name' => 'Images',
                'icon' => 'file-image',
                'extensions' => ['jpg', 'jpeg', 'png', 'svg', 'gif'],
            ],
            [
                'name' => 'Pdf',
                'icon' => 'file-pdf',
                'extensions' => ['pdf'],
            ],
            [
                'name' => 'Zip',
                'icon' => 'file-zip',
                'extensions' => ['zip'],
            ],
            [
                'name' => 'Présentation',
                'icon' => 'file-slides',
                'extensions' => ['odp', 'ppt', 'pptx'],
            ],
        ];
    }
}
