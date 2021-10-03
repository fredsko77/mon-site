<?php
namespace App\Services\Dashboard;

use App\Entity\Content;
use App\Services\Dashboard\ContentServicesInterface;
use App\Services\Uploader\ContentUploader;
use App\Utils\ServicesTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContentServices implements ContentServicesInterface
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

    /**
     * @var ContentUploader $uploader
     */
    private $uploader;

    /**
     * @var Filesystem $filesystem
     */
    private $filesystem;

    public function __construct(Security $security, EntityManagerInterface $manager, ValidatorInterface $validator, SerializerInterface $serializer, ContentUploader $uploader, Filesystem $filesystem)
    {
        $this->security = $security;
        $this->manager = $manager;
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->uploader = $uploader;
        $this->filesystem = $filesystem;
    }

    public function store(Request $request): object
    {
        $data = json_encode($request->request->all());
        $user = $this->security->getUser();
        $content = $this->serializer->deserialize($data, Content::class, 'json', ['object_to_populate' => $user->getContent() ?? (new Content)]);
        $file = $request->files->get('image');
        $violations = $this->filterViolations($this->validator->validate($content));

        if ($file instanceof UploadedFile) {
            $upload = $this->uploader->upload($file, $content);
            if (is_array($upload) && count($upload) > 0) {
                $violations = array_merge($violations, $upload);
            }
            $content->setImage($upload)
                ->setUser($user)
            ;
        }

        if (count($violations) > 0) {
            return $this->sendViolations($violations);
        }

        $content->getCreatedAt() === null ? $content->setCreatedAt($this->now()) : $content->setUpdatedAt($this->now());

        $this->manager->persist($content);
        $this->manager->flush();

        return $this->sendJson(
            $content,
            $content->getUpdatedAt() ? Response::HTTP_OK : Response::HTTP_ACCEPTED,
        );
    }

}
