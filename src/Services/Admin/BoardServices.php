<?php
namespace App\Services\Admin;

use App\Entity\Board;
use App\Entity\BoardList;
use App\Entity\BoardTag;
use App\Entity\Card;
use App\Entity\Room;
use App\Repository\BoardRepository;
use App\Repository\CardRepository;
use App\Services\Admin\BoardServicesInterface;
use App\Utils\ServicesTrait;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BoardServices implements BoardServicesInterface
{

    use ServicesTrait;

    /**
     * @var BoardRepository $repository
     */
    private $repository;

    /**
     * @var CardRepository $cardRepository
     */
    private $cardRepository;

    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    /**
     * @var CardFileServicesInterface $cardFileService
     */
    private $cardFileService;

    /**
     * @var SerializerInterface $serializer
     */
    private $serializer;

    /**
     * @var UrlGeneratorInterface $router
     */
    private $router;

    /**
     * @var ValidatorInterface $validator
     */
    private $validator;

    /**
     * @var PaginatorInterface $paginator
     */
    private $paginator;

    public function __construct(
        BoardRepository $repository,
        CardRepository $cardRepository,
        EntityManagerInterface $manager,
        CardFileServicesInterface $cardFileService,
        SerializerInterface $serializer,
        UrlGeneratorInterface $router,
        ValidatorInterface $validator,
        PaginatorInterface $paginator
    ) {
        $this->repository = $repository;
        $this->cardRepository = $cardRepository;
        $this->manager = $manager;
        $this->cardFileService = $cardFileService;
        $this->serializer = $serializer;
        $this->router = $router;
        $this->validator = $validator;
        $this->paginator = $paginator;
    }

    /**
     * @param FormInterface $form
     * @param Board $board
     * @param Room $room
     *
     * @return void
     */
    public function create(FormInterface $form, Board $board, Room $room): void
    {
        $faker = Factory::create('fr_FR');

        $board
            ->setCreatedAt(new DateTime());

        if ($form->get('defaultLists')->getData(true) === true) {
            $position = 1;
            foreach (Card::getStates() as $state) {
                $list = new BoardList;

                $list
                    ->setName($state)
                    ->setPosition((int) $position)
                    ->setCreatedAt(new DateTime())
                    ->setIsOpen(true)
                ;

                $board->addList($list);
                $position++;
            }
        }
        if ($form->get('defaultTags')->getData(true) === true) {
            foreach (Card::getStates() as $state) {
                $tag = new BoardTag;

                $tag
                    ->setName($state)
                    ->setColor($faker->hexColor())
                ;

                $board->addTag($tag);
            }
        }

        $this->manager->persist($board);
        $this->manager->flush();
    }

    /**
     * @param Board $board
     *
     * @return void
     */
    public function store(Board $board): void
    {
        $board->setUpdatedAt(new DateTime());

        $this->manager->persist($board);
        $this->manager->flush();
    }

    /**
     * @param Board $board
     *
     * @return object
     */
    public function delete(Board $board): object
    {
        if (count($board->getCards()) > 0) {
            foreach ($board->getCards() as $key => $card) {
                if ($card->getFiles()) {
                    foreach ($card->getFiles() as $key => $file) {
                        $this->cardFileService->deleteFile($file);
                    }
                }
            }
        }

        $this->manager->remove($board);
        $this->manager->flush();

        return $this->sendNoContent();
    }

    /**
     * @param Board $board
     *
     * @return object
     */
    public function toggle(Board $board): object
    {
        $board->setIsOpen(!$board->getIsOpen())
            ->setUpdatedAt(new DateTime)
        ;

        $this->manager->persist($board);
        $this->manager->flush();

        return $this->sendJson($board);
    }

    /**
     * @param Board $board
     * @param Request $request
     *
     * @return object
     */
    public function apiEdit(Board $board, Request $request): object
    {
        $data = $request->getContent();
        $board = $this->serializer->deserialize($data, Board::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $board]);
        $violations = $this->validator->validate($board);

        if (count($violations) > 0) {
            return $this->sendViolations($violations);
        }

        $board->setUpdatedAt(new DateTime);

        $this->manager->persist($board);
        $this->manager->flush();

        return $this->sendJson($board);
    }

    /**
     * @param Board $board
     *
     * @return object
     */
    public function apiDelete(Board $board): object
    {
        $location = $this->router->generate('admin_room_show', [
            'id' => $board->getRoom()->getId(),
        ]);

        if (count($board->getCards()) > 0) {
            foreach ($board->getCards() as $key => $card) {
                if ($card->getFiles()) {
                    foreach ($card->getFiles() as $key => $file) {
                        $this->cardFileService->deleteFile($file);
                    }
                }
            }
        }

        $this->manager->remove($board);
        $this->manager->flush();

        return $this->sendNoContent([
            'Location' => $location,
        ]);
    }

    public function filter(Board $board, Request $request): array
    {
        // Get data from $_GET
        $state = $request->query->getBoolean('isOpen', true);
        $sort = $request->query->get('sort', null);
        $page = $request->query->getInt('page', 1);
        $nbItems = $request->query->getInt('nbItems', 10);
        $tag = $request->query->get('tag', null);
        $search = $request->query->get('search', null);

        // Get data from Database|Repository
        $data = $this->getData($this->cardRepository->findBoardFilteredCards(
            $board,
            $state,
            $sort,
            $tag,
            $search
        ));

        // Get boards for pagination
        $cards = $this->paginator->paginate(
            $data,
            $page,
            $nbItems
        );

        return compact('cards', 'board');
    }

    /**
     * @param array $array
     *
     * @return array
     */
    private function getData(array $array): array
    {
        $data = [];
        foreach ($array as $key => $item) {
            if (is_array($item)) {
                $data[$key] = $item[0];
            } else {
                return $array;
            }
        }

        return $data;
    }
}
