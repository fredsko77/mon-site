<?php
namespace App\Services\Admin;

use App\Entity\Board;
use App\Entity\BoardList;
use App\Entity\BoardTag;
use App\Entity\Card;
use App\Entity\Room;
use App\Repository\BoardRepository;
use App\Services\Admin\BoardServicesInterface;
use App\Utils\ServicesTrait;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\Form\FormInterface;

class BoardServices implements BoardServicesInterface
{

    use ServicesTrait;

    /**
     * @var BoardRepository $repository
     */
    private $repository;

    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    /**
     * @var CardFileServicesInterface $cardFileService
     */
    private $cardFileService;

    public function __construct(
        BoardRepository $repository,
        EntityManagerInterface $manager,
        CardFileServicesInterface $cardFileService
    ) {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->cardFileService = $cardFileService;
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

}
