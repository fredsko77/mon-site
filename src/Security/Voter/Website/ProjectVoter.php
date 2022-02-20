<?php

namespace App\Security\Voter\Website;

use App\Entity\Project;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class ProjectVoter extends Voter
{

    /** Voter Constants */
    private const PROJECT_VIEW = 'project_view';

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
        return in_array($attribute, [self::PROJECT_VIEW])
        && $subject instanceof Project;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // ROLE_SUPER_ADMIN can do anything! The power!
        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }
        $project = $subject;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::PROJECT_VIEW:
                // logic to determine if the user can EDIT
                // return true or false
                return $this->canView($project);
                break;
        }

        return false;
    }

    private function canView(Project $project): bool
    {
        if ($project->getVisibility() === 'private') {
            return $this->security->isGranted('ROLE_ADMIN');
        }

        return true;
    }
}
