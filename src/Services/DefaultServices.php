<?php
namespace App\Services;

use App\Repository\ProjectRepository;
use App\Repository\SkillRepository;
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
     * @var SkillRepository $skillRepository
     */
    private $skillRepository;

    /**
     * @var SocialRespository $socialRepository
     */
    private $socialRepository;

    public function __construct(
        UserRepository $userRepository,
        ProjectRepository $projectRepository,
        SkillRepository $skillRepository,
        SocialRepository $socialRepository
    ) {
        $this->userRepository = $userRepository;
        $this->projectRepository = $projectRepository;
        $this->skillRepository = $skillRepository;
        $this->socialRepository = $socialRepository;
    }

    public function index(): array
    {
        $user = $this->userRepository->findOneBy(['email' => 'fagathe77@gmail.com']);
        $projects = $this->projectRepository->findBy(['visibility' => 'publique']);
        $socials = $this->socialRepository->findAll();
        $skills = $this->skillRepository->findAll();

        return compact('user', 'projects', 'socials', 'skills');
    }

}
