<?php

namespace App\DataFixtures;

use App\Entity\Board;
use App\Entity\BoardList;
use App\Entity\BoardTag;
use App\Entity\Card;
use App\Entity\CardFile;
use App\Entity\CardNote;
use App\Entity\CardTask;
use App\Entity\FileExtension;
use App\Entity\FileType;
use App\Entity\Room;
use App\Utils\FakerTrait;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BoardFixtures extends Fixture
{

    use FakerTrait;

    /**
     * @var FileType[] $fileTypes
     */
    private $fileTypes = [];

    /**
     * @var BoardTag[] $tags
     */
    private $tags = [];

    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        foreach ($this->getFileTypes() as $key => $file_type) {
            $fileType = new FileType;
            $fileType
                ->setName($file_type['name'])
                ->setIcon($file_type['icon'])
            ;
            foreach ($file_type['extensions'] as $extension) {
                $fileExtension = new FileExtension;

                $fileExtension

                    ->setExtension($extension['extension'])
                    ->setHasIcon(array_key_exists('hasIcon', $extension) ? $extension['hasIcon'] : false)
                    ->setIcon($fileExtension->getHasIcon() ? 'filetype-' . $fileExtension->getExtension() : null)
                ;

                $fileType->addFileExtension($fileExtension);
            }

            $manager->persist($fileType);

            $this->fileTypes[$key] = $fileType;
        }

        foreach ($this->getRooms() as $key => $board_type) {
            $room = new Room();
            $room
                ->setName($board_type['name'])
                ->setIcon($board_type['icon'])
                ->setDescription($board_type['description'])
                ->setCreatedAt($this->setDateTimeBetween())
                ->setUpdatedAt($this->setDateTimeAfter($room->getCreatedAt()))
            ;

            for ($b = 0; $b < random_int(30, 50); $b++) {
                $board = new Board;

                $board
                    ->setName($faker->words(random_int(1, 3), true))
                    ->setDescription($faker->sentences(random_int(2, 6), true))
                    ->setCreatedAt($this->setDateTimeAfter($room->getCreatedAt()))
                    ->setUpdatedAt($this->setDateTimeAfter($board->getCreatedAt()))
                    ->setDeadline($this->setDateTimeAfter($board->getCreatedAt()))
                    ->setIsOpen($b % 7 === 0 ? false : true)
                    ->setIsBookmarked($b % random_int(5, 8) === 0 ? true : false)
                ;

                for ($bt = 0; $bt < random_int(9, 15); $bt++) {
                    $tag = new BoardTag;

                    $tag
                        ->setName($faker->words(random_int(1, 2), true))
                        ->setColor($faker->randomElement(BoardTag::colors()))
                        ->setDescription($faker->words(random_int(2, 5), true))
                    ;

                    $board->addTag($tag);
                }

                $this->tags = $board->getTags()->toArray();

                $position = 1;

                foreach (Card::getStates() as $state) {
                    $list = new BoardList;

                    $list
                        ->setName($state)
                        ->setPosition((int) $position)
                        ->setCreatedAt($this->setDateTimeAfter($board->getCreatedAt()))
                        ->setUpdatedAt($this->setDateTimeAfter($list->getCreatedAt()))
                        ->setIsOpen(true)
                    ;

                    $this->generateCards($board, $faker, $list, 15);

                    $board->addList($list);
                    $position++;
                }

                $this->generateCards($board, $faker, null, 18, false);
                $this->generateCards($board, $faker, null, 20);

                $room->addBoard($board);
            }

            $manager->persist($room);
        }

        $manager->flush();
    }

    private function generateCards(Board $board, $faker, ?BoardList $list = null, ?int $limit = null, bool $open = true): Board
    {
        for ($c = 0; $c < random_int(4, ($limit ?? 20)); $c++) {
            $card = new Card;

            $card
                ->setName($faker->words(random_int(1, 3), true))
                ->setDescription($faker->sentences(random_int(2, 6), true))
                ->setCreatedAt($this->setDateTimeAfter($board->getCreatedAt()))
                ->setDeadline($this->setDateTimeAfter($card->getCreatedAt()))
                ->setUpdatedAt($this->setDateTimeAfter($card->getCreatedAt()))
                ->setIsOpen($open)
            ;

            for ($ct = 0; $ct < random_int(1, 3); $ct++) {
                $card->addTag($faker->randomElement($this->tags));
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
                    ->setFileType($this->fileTypes[3])
                    ->setCreatedAt($this->setDateTimeAfter($card->getCreatedAt()))
                ;

                $card->addFile($file);
            }

            if ($list instanceof BoardList) {
                $list->addCard($card);
            }

            $board->addCard($card);
        }

        return $board;
    }

    /**
     * Return an array of board types
     *
     * @return array
     *
     */
    private function getRooms(): array
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
                'name' => 'Pro',
                'icon' => 'building',
                'description' => 'Contenu à ajouter sur la partie docs',
            ],
            [
                'name' => 'Daily',
                'icon' => 'stickies',
                'description' => 'Les tâches du quotidien',
            ],
            [
                'name' => 'Formation',
                'icon' => 'mortarboard',
                'description' => 'Les tâches du quotidien',
            ],
            [
                'name' => 'Veille',
                'icon' => 'newspaper',
                'description' => 'Faire de la documentation',
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
                'extensions' => [
                    [
                        'extension' => 'ods',
                    ],
                    [
                        'extension' => 'xls',
                        'hasIcon' => true,
                    ],
                    [
                        'extension' => 'xlsx',
                        'hasIcon' => true,
                    ],
                ],
            ],
            [
                'name' => 'Texte',
                'icon' => 'file-text',
                'extensions' => [
                    [
                        'extension' => 'odt',
                    ],
                    [
                        'extension' => 'doc',
                        'hasIcon' => true,
                    ],
                    [
                        'extension' => 'docx',
                        'hasIcon' => true,
                    ],
                    [
                        'extension' => 'txt',
                        'hasIcon' => true,
                    ],
                ],
            ],
            [
                'name' => 'Code',
                'icon' => 'file-code',
                'extensions' => [
                    [
                        'extension' => 'log',
                    ],
                    [
                        'extension' => 'xml',
                        'hasIcon' => true,
                    ],
                    [
                        'extension' => 'twig',
                    ],
                    [
                        'extension' => 'html',
                        'hasIcon' => true,
                    ],
                    [
                        'extension' => 'php',
                        'hasIcon' => true,
                    ],
                    [
                        'extension' => 'js',
                        'hasIcon' => true,
                    ],
                    [
                        'extension' => 'md',
                        'hasIcon' => true,
                    ],
                    [
                        'extension' => 'yaml',
                    ],
                    [
                        'extension' => 'yml',
                        'hasIcon' => true,
                    ],
                    [
                        'extension' => 'json',
                        'hasIcon' => true,
                    ],
                    [
                        'extension' => 'env',
                    ],
                    [
                        'extension' => 'css',
                        'hasIcon' => true,
                    ],
                    [
                        'extension' => 'scss',
                        'hasIcon' => true,
                    ],
                    [
                        'extension' => 'sass',
                        'hasIcon' => true,
                    ],
                    [
                        'extension' => 'sql',
                    ],
                    [
                        'extension' => 'sh',
                        'hasIcon' => true,
                    ],
                    [
                        'extension' => 'py',
                        'hasIcon' => true,
                    ],
                    [
                        'extension' => 'htaccess',
                    ],
                    [
                        'extension' => 'conf',
                    ],
                ],
            ],
            [
                'name' => 'Images',
                'icon' => 'file-image',
                'extensions' => [
                    [
                        'extension' => 'jpg',
                        'hasIcon' => true,
                    ],
                    [
                        'extension' => 'jpeg',
                    ],
                    [
                        'extension' => 'png',
                        'hasIcon' => true,
                    ],
                    [
                        'extension' => 'svg',
                        'hasIcon' => true,
                    ],
                    [
                        'extension' => 'gif',
                        'hasIcon' => true,
                    ],
                ],
            ],
            [
                'name' => 'Pdf',
                'icon' => 'file-pdf',
                'extensions' => [
                    [
                        'extension' => 'pdf',
                        'hasIcon' => true,
                    ],
                ],
            ],
            [
                'name' => 'Zip',
                'icon' => 'file-zip',
                'extensions' => [
                    ['extension' => 'zip'],
                ],
            ],
            [
                'name' => 'Présentation',
                'icon' => 'file-slides',
                'extensions' => [
                    [
                        'extension' => 'odp',
                    ],
                    [
                        'extension' => 'ppt',
                        'hasIcon' => true,
                    ],
                    [
                        'extension' => 'pptx',
                        'hasIcon' => true,
                    ],
                ],
            ],
        ];
    }
}
