<?php
namespace App\Services;

use App\Repository\GroupSkillRepository;
use App\Repository\ProjectRepository;
use App\Repository\SocialRepository;
use App\Repository\UserRepository;
use App\Services\WebSiteServicesInterface;

class WebSiteServices implements WebSiteServicesInterface
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

    /**
     * @var GroupSkillRepository $groupSkillRepository
     */
    private $groupSkillRepository;

    public function __construct(
        UserRepository $userRepository,
        ProjectRepository $projectRepository,
        SocialRepository $socialRepository,
        GroupSkillRepository $groupSkillRepository
    ) {
        $this->userRepository = $userRepository;
        $this->projectRepository = $projectRepository;
        $this->socialRepository = $socialRepository;
        $this->groupSkillRepository = $groupSkillRepository;
    }

    public function index(): array
    {
        $user = $this->userRepository->findOneBy(['email' => 'fagathe77@gmail.com']);
        $projects = $this->projectRepository->findHomePageProjects();
        $socials = $this->socialRepository->findAll();
        $groupSkills = $this->groupSkillRepository->findAll();

        return compact('user', 'projects', 'socials', 'groupSkills');
    }

}
