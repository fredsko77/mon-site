<?php
namespace App\Services\Admin;

use App\Entity\CardFile;
use App\Services\Admin\CardFileServicesInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;

class CardFileServices implements CardFileServicesInterface
{

    /**
     * @var Filesystem $filesystem
     */
    private $filesystem;

    /**
     * @var ContainerInterface $container
     */
    private $container;

    public function __construct(
        Filesystem $filesystem,
        ContainerInterface $container
    ) {
        $this->filesystem = $filesystem;
        $this->container = $container;
    }

    /**
     * @param CardFile $cardFile
     *
     * @return void
     */
    public function deleteFile(CardFile $cardFile): void
    {
        if ($cardFile->getPath() !== null) {
            $file = $this->container->getParameter('root_directory') . $cardFile->getPath();
            if ($this->filesystem->exists($file)) {
                $this->filesystem->remove($file);
            }
        }
    }

}
