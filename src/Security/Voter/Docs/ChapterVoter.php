<?php

namespace App\Security\Voter\Docs;

use App\Entity\Chapter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class ChapterVoter extends Voter
{

    /**
     * @var Security $security
     */
    private $security;

    /** Voter Constants */
    private const CHAPTER_VIEW = 'chapter_view';
    private const CHAPTER_CREATE = 'chapter_create';
    private const CHAPTER_UPDATE = 'chapter_update';
    private const CHAPTER_DELETE = 'chapter_delete';
    private const CHAPTER_ACTION = 'chapter_action';

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [
            self::CHAPTER_VIEW,
            self::CHAPTER_CREATE,
            self::CHAPTER_UPDATE,
            self::CHAPTER_DELETE,
            self::CHAPTER_ACTION,
        ])
        && $subject instanceof \App\Entity\Chapter;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        $chapter = $subject;

        // ROLE_SUPER_ADMIN can do anything! The power!
        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::CHAPTER_CREATE:
                // logic to determine if the user can CREATE
                // return true or false
                return $this->canCreate();
                break;
            case self::CHAPTER_UPDATE:
                // logic to determine if the user can UPDATE
                // return true or false
                return $this->canUpdate();
                break;
            case self::CHAPTER_DELETE:
                // logic to determine if the user can CREATE
                // return true or false
                return $this->canDelete();
                break;
            case self::CHAPTER_VIEW:
                // logic to determine if the user can VIEW
                // return true or false
                return $this->canView($chapter);
                break;
            case self::CHAPTER_ACTION:
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
     * @param Chapter $chapter
     *
     * @return bool
     */
    private function canView(Chapter $chapter): bool
    {
        if ($chapter->getVisibility() === 'private') {

            return $this->security->isGranted('ROLE_ADMIN');
        }

        return true;
    }

}
