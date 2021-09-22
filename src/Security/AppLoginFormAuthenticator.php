<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class AppLoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';
    public const SUCCESS_ROUTE = 'admin_dashboard';

    /**
     * @var UrlGeneratorInterface $urlGenerator
     */
    private $urlGenerator;

    /**
     * @var UserPasswordHasherInterface $passwordEncoder
     */
    private $passwordEncoder;

    /**
     * @var UserRepository $userRepository
     */
    private $userRepository;

    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        UserPasswordHasherInterface $passwordEncoder,
        UserRepository $userRepository
    ) {
        $this->urlGenerator = $urlGenerator;
        $this->passwordEncoder = $passwordEncoder;
        $this->userRepository = $userRepository;
    }

    public function authenticate(Request $request): PassportInterface
    {
        $email = $request->request->get('username', '');
        $password = $request->request->get('password', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        $user = $this->getUser($request);

        if ($user instanceof User && $this->passwordEncoder->isPasswordValid($user, $password)) {
            if (!$user->getConfirm()) {

                throw new CustomUserMessageAuthenticationException('Votre compte n\'a pas encore été activé.');
            }

            return new Passport(
                new UserBadge($email),
                new PasswordCredentials($password),
                [
                    new CsrfTokenBadge('authenticate', $request->get('_csrf_token')),
                ]
            );
        }

        throw new CustomUserMessageAuthenticationException('Bad credentials.');
    }

    protected function getUser(Request $request): ?User
    {
        return $this->userRepository->findOneBy(['email' => $request->request->get('email', '')]);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate(self::SUCCESS_ROUTE));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
