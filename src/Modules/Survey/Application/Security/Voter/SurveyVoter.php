<?php

namespace App\Modules\Survey\Application\Security\Voter;

use App\Modules\Survey\Domain\Entity\Survey;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class SurveyVoter extends Voter
{
    public const DELETE = 'DELETE';
    public const EDIT = 'EDIT';
    public const ANSWER = 'ANSWER';
    public const PUBLISH = 'PUBLISH';
    public const FINISH = 'FINISH';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::DELETE, self::EDIT, self::ANSWER, self::PUBLISH, self::FINISH])
            && $subject instanceof Survey;
    }

    /**
     * @param  Survey  $subject
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        return match ($attribute) {
            self::EDIT => $subject->getStatus() === Survey::STATUS_NEW,
            self::PUBLISH => $subject->getStatus() === Survey::STATUS_NEW,
            self::DELETE => $subject->getStatus() === Survey::STATUS_NEW,
            self::ANSWER => $subject->getStatus() === Survey::STATUS_LIVE,
            self::FINISH => $subject->getStatus() === Survey::STATUS_LIVE,
            default => false,
        };
    }
}
