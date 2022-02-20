<?php

namespace App\Security\Voter\Docs;

use App\Entity\Book;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class BookVoter extends Voter
{

    /**
     * @var Security $security
     */
    private $security;

    /** Voter Constants */
    private const BOOK_VIEW = 'book_view';
    private const BOOK_CREATE = 'book_create';
    private const BOOK_UPDATE = 'book_update';
    private const BOOK_DELETE = 'book_delete';
    private const BOOK_ACTION = 'book_action';

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [
            self::BOOK_VIEW,
            self::BOOK_CREATE,
            self::BOOK_UPDATE,
            self::BOOK_DELETE,
            self::BOOK_ACTION,
        ])
        && $subject instanceof \App\Entity\Book;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        $book = $subject;

        // ROLE_SUPER_ADMIN can do anything! The power!
        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::BOOK_CREATE:
                // logic to determine if the user can CREATE
                // return true or false
                return $this->canCreate();
                break;
            case self::BOOK_UPDATE:
                // logic to determine if the user can UPDATE
                // return true or false
                return $this->canUpdate();
                break;
            case self::BOOK_DELETE:
                // logic to determine if the user can CREATE
                // return true or false
                return $this->canDelete();
                break;
            case self::BOOK_VIEW:
                // logic to determine if the user can VIEW
                // return true or false
                return $this->canView($book);
                break;
            case self::BOOK_ACTION:
                // logic to determine if the user can VIEW
                // return true or false
                return $this->canAction();
                break;
        }

        return false;
    }

    /**
     * @return bool
     */
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
     * @param Book $book
     *
     * @return bool
     */
    private function canView(Book $book): bool
    {
        if ($book->getVisibility() === 'private') {

            return $this->security->isGranted('ROLE_ADMIN');
        }

        return true;
    }
}
