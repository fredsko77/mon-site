<?php

namespace App\Security\Voter\Docs;

use App\Entity\Page;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class PageVoter extends Voter
{

    /** Voter Constants */
    private const PAGE_UPDATE = 'page_edit';
    private const PAGE_VIEW = 'page_view';
    private const PAGE_DELETE = 'page_edit';
    private const PAGE_CREATE = 'page_create';
    private const PAGE_ACTION = 'page_action';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [
            self::PAGE_CREATE,
            self::PAGE_DELETE,
            self::PAGE_VIEW,
            self::PAGE_UPDATE,
            self::PAGE_ACTION,
        ])
        && $subject instanceof Page;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        $page = $subject;

        // ROLE_SUPER_ADMIN can do anything! The power!
        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::PAGE_CREATE:
                // logic to determine if the user can CREATE
                // return true or false
                return $this->canCreate();
                break;
            case self::PAGE_UPDATE:
                // logic to determine if the user can UPDATE
                // return true or false
                return $this->canUpdate();
                break;
            case self::PAGE_DELETE:
                // logic to determine if the user can CREATE
                // return true or false
                return $this->canDelete();
                break;
            case self::PAGE_VIEW:
                // logic to determine if the user can VIEW
                // return true or false
                return $this->canView($page);
                break;
            case self::PAGE_ACTION:
                // logic to determine if the user can VIEW
                // return true or false
                return $this->canAction($user, $page);
                break;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function canAction($user): bool
    {
        return $this->security->isGranted('ROLE_ADMIN');
    }

    /**
     * @return bool
     */
    private function canCreate(): bool
    {
        return $this->security->isGranted('ROLE_ADMIN');
    }

    /**
     * @return bool
     */
    private function canDelete(): bool
    {
        return $this->security->isGranted('ROLE_ADMIN');
    }

    /**
     * @return bool
     */
    private function canUpdate(): bool
    {
        return $this->security->isGranted('ROLE_ADMIN');
    }

    /**
     * @param Page $page
     *
     * @return bool
     */
    private function canView(Page $page): bool
    {
        if ($page->getVisibility() === 'private') {

            return $this->security->isGranted('ROLE_ADMIN');
        }

        return true;
    }

}
