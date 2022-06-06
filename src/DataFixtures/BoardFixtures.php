<?php

namespace App\DataFixtures;

use App\Entity\Board;
use App\Entity\BoardTag;
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

        $manager->flush();
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
