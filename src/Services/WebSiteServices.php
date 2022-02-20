<?php
namespace App\Services;

use App\Entity\Contact;
use App\Entity\Project;
use App\Mailing\Contact\ContactMailing;
use App\Repository\GroupSkillRepository;
use App\Repository\ProjectRepository;
use App\Repository\SocialRepository;
use App\Repository\UserRepository;
use App\Services\WebSiteServicesInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

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

    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    /**
     * @var ContactMailing $mailing
     */
    private $mailing;

    /**
     * @var Security $security
     */
    private $security;

    public function __construct(
        UserRepository $userRepository,
        ProjectRepository $projectRepository,
        SocialRepository $socialRepository,
        GroupSkillRepository $groupSkillRepository,
        EntityManagerInterface $manager,
        ContactMailing $mailing,
        Security $security
    ) {
        $this->userRepository = $userRepository;
        $this->projectRepository = $projectRepository;
        $this->socialRepository = $socialRepository;
        $this->groupSkillRepository = $groupSkillRepository;
        $this->manager = $manager;
        $this->mailing = $mailing;
        $this->security = $security;
    }

    public function index(): array
    {
        $user = $this->userRepository->findOneBy(['email' => 'fagathe77@gmail.com']);
        $projects = $this->projectRepository->findHomePageProjects();
        $socials = $this->socialRepository->findAll();
        $groupSkills = $this->groupSkillRepository->findAll();

        return compact('user', 'projects', 'socials', 'groupSkills');
    }

    /**
     * @param Contact $contact
     *
     * @return void
     */
    public function contact(Contact $contact): void
    {
        $contact->setState(Contact::STATE_PENDING)
            ->setCreatedAt(new DateTime)
        ;

        $this->manager->persist($contact);
        $this->manager->flush();

        $this->mailing->contact($contact);
    }

    /**
     * @return Project[]|null
     */
    public function projects(): ?array
    {
        return $this->security->isGranted('ROLE_ADMIN') ? $this->projectRepository->findAll() : $this->projectRepository->findBy(['visibility' => 'public']);
    }

}
