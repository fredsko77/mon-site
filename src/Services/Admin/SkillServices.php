<?php
namespace App\Services\Admin;

use App\Entity\Skill;
use App\Repository\SkillRepository;
use App\Services\Admin\SkillServicesInterface;
use App\Utils\ServicesTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SkillServices implements SkillServicesInterface
{

    use ServicesTrait;

    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    /**
     * @var ValidatorInterface $validator
     */
    private $validator;

    /**
     * @var SerializerInterface $serializer
     */
    private $serializer;

    /**
     * @var SkillRepository $repository
     */
    private $repository;

    /**
     * @var UrlGeneratorInterface $router
     */
    private $router;

    public function __construct(
        EntityManagerInterface $manager,
        ValidatorInterface $validator,
        SerializerInterface $serializer,
        SkillRepository $repository,
        UrlGeneratorInterface $router
    ) {
        $this->manager = $manager;
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->repository = $repository;
        $this->router = $router;
    }

    /**
     * @return array
     */
    public function index(): array
    {
        return [
            'skills' => $this->repository->findAll(),
            'colors' => $this->getColors(),
        ];
    }

    /**
     * @param Request $request
     *
     * @return object
     */
    public function create(Request $request): object
    {
        $skill = $this->serializer->deserialize($request->getContent(), Skill::class, 'json');
        $violations = $this->filterViolations($this->validator->validate($skill));

        if (count($violations) > 0) {
            return $this->sendViolations($violations);
        }

        $skill->setCreatedAt($this->now());

        $this->manager->persist($skill);
        $this->manager->flush();

        return $this->sendJson(
            $skill,
            Response::HTTP_CREATED,
            [
                'Location' => $this->router->generate('admin_skill_edit', [
                    'id' => $skill->getId(),
                ], UrlGenerator::ABSOLUTE_URL),
            ]
        );
    }

    /**
     * @return array
     */
    public function edit(Skill $skill): array
    {

        return [
            'skill' => $skill,
            'colors' => $this->getColors(),
        ];
    }

    /**
     * @param Request $request
     * @param Skill $skill
     *
     * @return object
     */
    public function store(Request $request, Skill $skill): object
    {

        $skill = $this->serializer->deserialize($request->getContent(), Skill::class, 'json', ['object_to_populate' => $skill]);
        $violations = $this->filterViolations($this->validator->validate($skill));

        if (count($violations) > 0) {
            return $this->sendViolations($violations);
        }

        $skill
            ->setUpdatedAt($this->now())
        ;

        $this->manager->persist($skill);
        $this->manager->flush();

        return $this->sendJson(
            $skill,
            Response::HTTP_OK,
            [
                'Location' => $this->router->generate('app_default', [], UrlGenerator::ABSOLUTE_URL),
            ]
        );
    }

    /**
     * @param Skill $skill
     *
     * @return object
     */
    public function delete(Skill $skill): object
    {
        $this->manager->remove($skill);
        $this->manager->flush();

        return $this->sendNoContent();
    }

    /**
     * @return array
     */
    private function getColors(): array
    {

        return [
            'crm' => 'crm',
            'danger' => 'danger',
            'info' => 'info',
            'light' => 'light',
            'primary' => 'primary',
            'secondary' => 'secondary',
            'success' => 'success',
            'warning' => 'warning',
        ];
    }

}
