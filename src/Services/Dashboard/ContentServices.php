<?php
namespace App\Services\Dashboard;

use App\Services\Dashboard\ContentServicesInterface;
use App\Utils\ServicesTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContactServices implements ContentServicesInterface
{

    use ServicesTrait;

    /**
     * @var Security $security
     */
    private $security;

    /**
     *@var EntityManagerInterface $manager
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

    public function __construct(Security $security, EntityManagerInterface $manager, ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $this->security = $security;
        $this->manager = $manager;
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    public function store(Request $request): object
    {
        return $this->sendJson();
    }
    
}
