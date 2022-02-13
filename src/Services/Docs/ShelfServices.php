<?php
namespace App\Services\Docs;

use App\Entity\Book;
use App\Entity\Shelf;
use App\Repository\ShelfRepository;
use App\Services\Docs\ShelfServicesInterface;
use App\Utils\ServicesTrait;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

class ShelfServices implements ShelfServicesInterface
{

    use ServicesTrait;

    /**
     * @var ShelfRepository $repository
     */
    private $repository;

    /**
     * @var ContainerInterface $container
     */
    private $container;

    /**
     * @var Filesystem $filesystem
     */
    private $filesystem;

    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    /**
     * @var Slugify $slugger
     */
    private $slugger;

    /**
     * @var Session $session
     */
    private $session;

    /**
     * @var PaginatorInterface $paginator
     */
    private $paginator;

    /**
     * @var Security $security
     */
    private $security;

    /**
     * @var UrlGeneratorInterface $router
     */
    private $router;

    public function __construct(
        ShelfRepository $repository,
        ContainerInterface $container,
        EntityManagerInterface $manager,
        Filesystem $filesystem,
        PaginatorInterface $paginator,
        Security $security,
        UrlGeneratorInterface $router
    ) {
        $this->repository = $repository;
        $this->container = $container;
        $this->manager = $manager;
        $this->filesystem = $filesystem;
        $this->slugger = new Slugify;
        $this->session = new Session;
        $this->paginator = $paginator;
        $this->security = $security;
        $this->router = $router;
    }

    /**
     * @param FormInterface $form
     * @param Shelf $shelf
     * @param Request $request
     *
     * @return void
     */
    public function store(FormInterface $form, Shelf $shelf, Request $request): void
    {
        $image = $form->get('uploadedFile')->getData();
        $shelf->getId() !== null ? $shelf->setUpdatedAt($this->now()) : $shelf->setCreatedAt($this->now());

        $shelf->setSlug(
            $this->slugger->slugify(
                $shelf->getSlug() ?? $shelf->getTitle(),
                '-'
            )
        );

        if ($image instanceof UploadedFile) {

            $filename = md5(uniqid()) . '.' . $image->guessExtension();

            $image->move(
                $this->container->getParameter('shelf_directory'),
                $filename
            );

            $this->deleteImage($shelf);

            $shelf->setImage('/uploads/shelf/' . $filename);

            $this->session->getFlashBag()->add(
                'info',
                'Le contenu a été mis à jour'
            );
        }

        $this->manager->persist($shelf);
        $this->manager->flush();
    }

    /**
     * @param Request $request
     *
     * @return PaginationInterface
     */
    public function paginate(Request $request): PaginationInterface
    {
        $user = $this->security->getUser();
        $data = $user !== null && in_array('ROLE_ADMIN', $user->getRoles(), true) ? $this->repository->findAll() : $this->repository->findBy(['visibility' => 'public']);

        return $this->paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            15
        );
    }

    /**
     * @param Shelf $shelf
     *
     * @return object
     */
    public function delete(Shelf $shelf): object
    {
        $this->deleteImage($shelf);

        $location = $this->router->generate('docs_shelf_index');

        $this->manager->remove($shelf);
        $this->manager->flush();

        return $this->sendNoContent([
            'Location' => $location,
        ]);
    }

    /**
     * @param Shelf $shelf
     *
     * @return void
     */
    private function deleteImage(Shelf $shelf): void
    {
        if ($shelf->getImage() !== null) {
            $file = $this->container->getParameter('root_directory') . $shelf->getImage();
            if ($this->filesystem->exists($file)) {
                $this->filesystem->remove($file);
            }
        }
    }

    /**
     * @param Book $book
     * @param Shelf $shelf
     *
     * @return void
     */
    public function newBook(Book $book, ?Shelf $shelf = null): void
    {
        $book
            ->setSlug(
                $this->slugger->slugify(
                    $book->getSlug() ?? $book->getTitle(),
                    '-'
                )
            )
            ->setCreatedAt(new \DateTime)
        ;

        $shelf->addBook($book);

        $this->manager->persist($shelf);
        $this->manager->flush();
    }

    /**
     * @param Book $book
     *
     * @return void
     */
    public function editBook(Book $book): void
    {
        $book
            ->setSlug(
                $this->slugger->slugify(
                    $book->getSlug() ?? $book->getTitle(),
                    '-'
                )
            )
            ->setUpdatedAt(new \DateTime)
        ;

        $this->manager->persist($book);
        $this->manager->flush();
    }

}
