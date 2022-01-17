<?php
namespace App\Twig;

use App\Entity\Social;
use App\Repository\SocialRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{

    /**
     * @var SocialRepository $socialRepository
     */
    private $socialRepository;

    public function __construct(SocialRepository $socialRepository)
    {
        $this->socialRepository = $socialRepository;
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('socials', [$this, 'socials']),
        ];
    }

    /**
     * @return null|Social[]
     */
    public function socials(): array | null
    {
        return $this->socialRepository->findAll();
    }

}
