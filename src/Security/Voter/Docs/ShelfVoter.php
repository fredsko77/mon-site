<?php

namespace App\Security\Voter\Docs;

use App\Entity\Shelf;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ShelfVoter extends Voter
{

    /** Voter Constants */
    private const SHELF_VIEW = 'shelf_view';
    private const SHELF_CREATE = 'shelf_create';
    private const SHELF_DELETE = 'shelf_delete';
    private const SHELF_UPDATE = 'shelf_update';
    private const SHELF_ACTION = 'shelf_action';

    /**
     * @var Security $security
     */
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
            self::SHELF_VIEW,
            self::SHELF_CREATE,
            self::SHELF_DELETE,
            self::SHELF_UPDATE,
            self::SHELF_ACTION,
        ])
        && $subject instanceof Shelf;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // ROLE_SUPER_ADMIN can do anything! The power!
        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }
        $shelf = $subject;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::SHELF_VIEW:
                // logic to determine if the user can EDIT
                // return true or false
                return $this->canView($user, $shelf);
                break;
            case self::SHELF_CREATE:
                // logic to determine if the user can CREATE
                // return true or false
                return $this->canCreate($user);
                break;
            case self::SHELF_DELETE:
                // logic to determine if the user can DELETE
                // return true or false
                return $this->canDelete($user);
                break;
            case self::SHELF_UPDATE:
                // logic to determine if the user can UPDATE
                // return true or false
                return $this->canUpdate($user);
                break;
            case self::SHELF_ACTION:
                // logic to determine if the user can ACTION
                // return true or false
                return $this->canAction($user);
                break;
        }

        return false;
    }

    private function canAction($user): bool
    {
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        return in_array('ROLE_ADMIN', $user->getRoles());
    }

    /**
     * @param mixed $user
     *
     * @return bool
     */
    private function canCreate($user): bool
    {
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        return in_array('ROLE_ADMIN', $user->getRoles());
    }

    /**
     * @param mixed $user
     *
     * @return bool
     */
    private function canDelete($user): bool
    {
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        return in_array('ROLE_ADMIN', $user->getRoles());
    }

    /**
     * @param mixed $user
     *
     * @return bool
     */
    private function canUpdate($user): bool
    {
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        return in_array('ROLE_ADMIN', $user->getRoles());
    }

    /**
     * @param mixed $user
     * @param Shelf $shelf
     *
     * @return bool
     */
    private function canView($user, Shelf $shelf): bool
    {
        if ($shelf->getVisibility() === 'public') {
            return true;
        }
        if ($shelf->getVisibility() === 'private' && $user instanceof UserInterface) {

            return in_array('ROLE_ADMIN', $user->getRoles());
        }

        return false;
    }
}
