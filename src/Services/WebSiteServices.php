<?php
namespace App\Services;

use DateTime;
use App\Entity\Contact;
use App\Mailing\Contact\ContactMailing;
use App\Repository\UserRepository;
use App\Repository\SocialRepository;
use App\Repository\ProjectRepository;
use App\Repository\GroupSkillRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    /**
     * @var ContactMailing $mailing
     */
    private $mailing;

    public function __construct(
        UserRepository $userRepository,
        ProjectRepository $projectRepository,
        SocialRepository $socialRepository,
        GroupSkillRepository $groupSkillRepository,
        EntityManagerInterface $manager,
        ContactMailing $mailing
    ) {
        $this->userRepository = $userRepository;
        $this->projectRepository = $projectRepository;
        $this->socialRepository = $socialRepository;
        $this->groupSkillRepository = $groupSkillRepository;
        $this->manager = $manager;
        $this->mailing = $mailing;
    }

    public function index(): array
    {
        $user = $this->userRepository->findOneBy(['email' => 'fagathe77@gmail.com']);
        $projects = $this->projectRepository->findHomePageProjects();
        $socials = $this->socialRepository->findAll();
        $groupSkills = $this->groupSkillRepository->findAll();

        return compact('user', 'projects', 'socials', 'groupSkills');
    }

    public function contact(Contact $contact): void
    {
        $contact->setState(Contact::STATE_PENDING)
            ->setCreatedAt(new DateTime)
        ;

        $this->manager->persist($contact);
        $this->manager->flush();

        $this->mailing->contact($contact);

        // TODO: Insérer le contact en base de données
        // TODO: Envoyer un mail recap au contact
    }

}
