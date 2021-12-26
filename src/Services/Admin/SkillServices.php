<?php
namespace App\Services\Admin;

use App\Entity\GroupSkill;
use App\Repository\GroupSkillRepository;
use App\Services\Admin\SkillServicesInterface;
use App\Utils\ServicesTrait;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SkillServices implements SkillServicesInterface
{

    use ServicesTrait;

    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    /**
     * @var GroupSkillRepository $repository
     */
    private $repository;

    /**
     * @var Session $session
     */
    private $session;

    /**
     * @var UrlGeneratorInterface $router
     */
    private $router;

    public function __construct(EntityManagerInterface $manager, GroupSkillRepository $repository, UrlGeneratorInterface $router)
    {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->router = $router;
        $this->session = new Session;
    }

    /**
     * @return array
     */
    public function index(): array
    {
        return [
            'groupSkills' => $this->repository->findAll(),
        ];
    }
    /**
     * @param Request $request
     * @param GroupSkill $GroupSkill
     */
    public function store(GroupSkill $groupSkill, FormInterface $form)
    {
        $groupSkill->getId() === null ? $groupSkill->setCreatedAt(new DateTime) : $groupSkill->setUpdatedAt(new DateTime);

        $this->manager->persist($groupSkill);
        $this->manager->flush();

        $this->session->getFlashBag()->add(
            'info',
            'Le groupe a bien été ' . ($groupSkill->getId() ? 'modifié' : 'crée') . ' !'
        );
    }

    /**
     * @param GroupSkill $GroupSkill
     *
     * @return object
     */
    public function delete(GroupSkill $groupSkill): object
    {
        $this->manager->remove($groupSkill);
        $this->manager->flush();

        return $this->sendJson(
            [],
            Response::HTTP_NO_CONTENT,
            []
        );
    }

}
