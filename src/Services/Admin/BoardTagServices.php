<?php
namespace App\Services\Admin;

use App\Entity\Board;
use App\Entity\BoardTag;
use App\Repository\BoardTagRepository;
use App\Services\Admin\BoardTagServicesInterface;
use App\Utils\ServicesTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BoardTagServices implements BoardTagServicesInterface
{

    use ServicesTrait;

    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    /**
     * @var BoardTagRepository $repository
     */
    private $repository;

    /**
     * @var UrlGeneratorInterface $router
     */
    private $router;

    /**
     * @var ValidatorInterface $validator
     */
    private $validator;

    /**
     * @var SerializerInterface $serializer
     */
    private $serializer;

    public function __construct(
        EntityManagerInterface $manager,
        BoardTagRepository $repository,
        UrlGeneratorInterface $router,
        ValidatorInterface $validator,
        SerializerInterface $serializer
    ) {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->router = $router;
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    /**
     * @param BoardTag $tag
     *
     * @return object
     */
    public function edit(BoardTag $tag, Request $request): object
    {
        $data = $request->getContent();
        $tag = $this->serializer->deserialize($data, BoardTag::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $tag]);

        $violations = $this->validator->validate($tag);

        if (count($violations) > 0) {
            return $this->sendViolations($violations);
        }

        $this->manager->persist($tag);
        $this->manager->flush();

        return $this->sendJson(
            $tag,
            Response::HTTP_OK,
            [
                'Location' => $this->router->generate('admin_api_board_tag_edit', [
                    'id' => $tag->getId(),
                ]),
            ]
        );
    }

    /**
     * @param Board $board
     * @param Request $request
     *
     * @return object
     */
    public function create(Board $board, Request $request): object
    {
        $data = $request->getContent();
        $tag = $this->serializer->deserialize($data, BoardTag::class, 'json');
        $violations = $this->validator->validate($tag);

        if (count($violations) > 0) {
            return $this->sendViolations($violations);
        }

        $tag->setBoard($board);

        $this->manager->persist($tag);
        $this->manager->flush();

        return $this->sendJson(
            $tag,
            Response::HTTP_CREATED,
            [
                'Location' => $this->router->generate('admin_api_board_tag_edit', [
                    'id' => $tag->getId(),
                ]),
            ]
        );
    }

    /**
     * @param BoardTag $tag
     *
     * @return object
     */
    public function delete(BoardTag $tag): object
    {
        $this->manager->remove($tag);
        $this->manager->flush();

        return $this->sendNoContent();
    }

    /**
     * @param Board $board
     *
     * @return object
     */
    public function listTags(Board $board): object
    {
        $tags = [];

        foreach ($board->getTags() as $key => $tag) {
            $tags[$key] = [
                'tag' => $tag,
                'link' => $this->router->generate('admin_api_board_tag_edit', [
                    'id' => $tag->getId(),
                ]),
            ];
        }

        return $this->sendJson(
            $tags
        );
    }

    /**
     * @param BoardTag $tag
     *
     * @return object
     */
    public function show(BoardTag $tag): object
    {
        return $this->sendJson([
            'tag' => $tag,
            'link' => $this->router->generate('admin_api_board_tag_show', [
                'id' => $tag->getId(),
            ]),
        ]);
    }

}
