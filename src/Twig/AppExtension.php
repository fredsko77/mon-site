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
            new TwigFunction('getClass', [$this, 'getClass']),
            new TwigFunction('setClass', [$this, 'setClass']),
            new TwigFunction('getType', [$this, 'getType']),
            new TwigFunction('isinstanceof', [$this, 'isinstanceof']),
            new TwigFunction('strlen', [$this, 'strLength']),
        ];
    }

    /**
     * @return null|Social[]
     */
    public function socials(): ?array
    {
        return $this->socialRepository->findAll();
    }

    /**
     * @param mixed $param
     *
     * @return string|null
     */
    public function getClass(mixed $param): ?string
    {
        if (is_object($param)) {

            return (string) $param::class;
        }

        return null;
    }

    public function setClass(?string $string = null): ?string
    {
        if (is_string($string)) {
            $string = preg_split('/(?=[A-Z])/', $string, -1, PREG_SPLIT_NO_EMPTY);
            $string = join("\\", $string);

            return $string;
        }

        return null;
    }

    /**
     * @param mixed $var
     *
     * @return string
     */
    public function getType(mixed $var): string
    {
        return gettype($var);
    }

    /**
     * @param mixed|null $subject
     * @param string $class
     *
     * @return bool
     */
    public function isinstanceof($subject = null, string $class = ''): bool
    {
        if (is_object($subject)) {
            return $subject instanceof $class;
        }

        return false;
    }

    /**
     * @param string|null $subject
     *
     * @return int
     */
    public function strLength(?string $subject): int
    {
        return strlen($subject);
    }

}
