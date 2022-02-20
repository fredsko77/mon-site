<?php

namespace App\Security\Voter\Docs;

use App\Entity\Shelf;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

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
                return $this->canView($shelf);
                break;
            case self::SHELF_CREATE:
                // logic to determine if the user can CREATE
                // return true or false
                return $this->canCreate();
                break;
            case self::SHELF_DELETE:
                // logic to determine if the user can DELETE
                // return true or false
                return $this->canDelete();
                break;
            case self::SHELF_UPDATE:
                // logic to determine if the user can UPDATE
                // return true or false
                return $this->canUpdate();
                break;
            case self::SHELF_ACTION:
                // logic to determine if the user can ACTION
                // return true or false
                return $this->canAction();
                break;
        }

        return false;
    }

    private function canAction(): bool
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
     * @param Shelf $shelf
     *
     * @return bool
     */
    private function canView(Shelf $shelf): bool
    {
        if ($shelf->getVisibility() === 'public') {
            return true;
        }
        if ($shelf->getVisibility() === 'private') {

            return $this->security->isGranted('ROLE_ADMIN');
        }

        return false;
    }
}
