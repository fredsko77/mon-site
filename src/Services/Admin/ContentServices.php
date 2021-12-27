<?php
namespace App\Services\Admin;

use App\Entity\Content;
use App\Repository\ContentRepository;
use App\Services\Admin\ContentServicesInterface;
use App\Utils\ServicesTrait;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Security;

class ContentServices implements ContentServicesInterface
{

    use ServicesTrait;

    /**
     * @var Security $security
     */
    private $security;

    /**
     *@var EntityManagerInterface $manager
     */
    private $manager;

    /**
     * @var Filesystem $filesystem
     */
    private $filesystem;

    /**
     * @var ContentRepository $repository
     */
    private $repository;

    /**
     * @var ContainerInterface $container
     */
    public $container;

    /**
     * @var Session $session
     */
    private $session;

    public function __construct(
        Security $security,
        EntityManagerInterface $manager,
        Filesystem $filesystem,
        ContentRepository $repository,
        ContainerInterface $container,
    ) {
        $this->security = $security;
        $this->manager = $manager;
        $this->filesystem = $filesystem;
        $this->repository = $repository;
        $this->container = $container;
        $this->session = new Session;
    }

    /**
     * @param FormInterface $form
     * @param Content $content
     *
     * @return void
     */
    public function store(FormInterface $form, Content $content)
    {
        $image = $form->get('uploadedFile')->getData();
        $content->getId() !== null ? $content->setUpdatedAt(new DateTime) : $content->setCreatedAt(new DateTime);

        if ($image instanceof UploadedFile) {
            $filename = md5(uniqid()) . '.' . $image->guessExtension();

            $image->move(
                $this->container->getParameter('content_directory'),
                $filename
            );

            $content->setImage('/uploads/content/' . $filename);

            $this->deleteImage($content);

            $this->session->getFlashBag()->add(
                'info',
                'Le contenu a été mis à jour'
            );
        }

        $this->manager->persist($content);
        $this->manager->flush();

    }

    /**
     * @return array|null
     */
    public function all(): ?array
    {
        return $this->repository->findAll();
    }

    /**
     * @param Content $content
     *
     * @return object
     */
    public function delete(Content $content): object
    {

        $this->deleteImage($content);

        $this->manager->remove($content);
        $this->manager->flush();

        $this->session->getFlashBag()->add('info', 'Le contenu a été supprimé');

        return $this->sendJson(
            [],
            Response::HTTP_NO_CONTENT,
            [
                'location' => $this->router->generate('admin_content_list'),
            ]
        );
    }

    private function deleteImage(Content $content): void
    {
        if ($content->getImage() !== null) {
            $file = $this->container->getParameter('root_directory') . $content->getImage();
            if ($this->filesystem->exists($file)) {
                $this->filesystem->remove($file);
            }
        }
    }

}
