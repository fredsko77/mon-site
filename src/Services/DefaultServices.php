<?php
namespace App\Services;

use App\Repository\ProjectRepository;
use App\Repository\SocialRepository;
use App\Repository\UserRepository;
use App\Services\DefaultServicesInterface;

class DefaultServices implements DefaultServicesInterface
{

    /**
     * @var UserRepository $userRepository
     */
    private $userRepository;

    /**
     * @var ProjectRepository $projectRepository
     */
    private $projectRepository;

    /**
     * @var SocialRespository $socialRepository
     */
    private $socialRepository;

    public function __construct(
        UserRepository $userRepository,
        ProjectRepository $projectRepository,
        SocialRepository $socialRepository
    ) {
        $this->userRepository = $userRepository;
        $this->projectRepository = $projectRepository;
        $this->socialRepository = $socialRepository;
    }

    public function index(): array
    {
        $user = $this->userRepository->findOneBy(['email' => 'fagathe77@gmail.com']);
        $projects = $this->projectRepository->findBy(['visibility' => 'publique']);
        $socials = $this->socialRepository->findAll();

        return compact('user', 'projects', 'socials');
    }

}
