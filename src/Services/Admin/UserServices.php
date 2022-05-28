<?php
namespace App\Services\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\Admin\UserServicesInterface;
use App\Utils\ServicesTrait;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserServices implements UserServicesInterface
{

    use ServicesTrait;

    /**
     * @var PaginatorInterface $paginator
     */
    private $paginator;

    /**
     * @var UserRepository $repository
     */
    private $repository;

    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    /**
     * @var UserPasswordHasherInterface $hasher
     */
    private $hasher;

    /**
     * @var Slugify $slugger
     */
    private $slugger;

    public function __construct(
        PaginatorInterface $paginator,
        UserRepository $repository,
        EntityManagerInterface $manager,
        UserPasswordHasherInterface $hasher
    ) {
        $this->paginator = $paginator;
        $this->repository = $repository;
        $this->manager = $manager;
        $this->hasher = $hasher;
        $this->slugger = new Slugify;
    }

    public function index(Request $request): array
    {
        // Get data from $_GET
        $page = $request->query->getInt('page', 1);
        $nbItems = $request->query->getInt('nbItems', 15);

        // Get data from Database|Repository
        $data = $this->repository->findAll();

        // Get boards for pagination
        $users = $this->paginator->paginate(
            $data,
            $page,
            $nbItems
        );

        return compact('users');
    }

    public function create(User $user): void
    {
    }

    public function edit(User $user): void
    {

    }

    public function delete(User $user): object
    {
        return $this->sendNoContent();
    }

}
