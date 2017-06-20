<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Exception\UserPasswordValidationException;

class UserPasswordValidator
{
    public function assertPasswordValid(User $user, string $password): void
    {
        if (strlen($password) < 8) {
            throw UserPasswordValidationException::invalidLength();
        }

        if ($user->verifyPassword($password)) {
            throw UserPasswordValidationException::matchesExistingPassword();
        }

        $tooSimilarValues = [
            $user->getFirstName(),
            $user->getLastName(),
            $user->getFullName(),
            $user->getEmail(),
        ];

        foreach ($tooSimilarValues as $text) {
            if ($this->isTooSimilar($password, $text)) {
                throw UserPasswordValidationException::tooSimilar();
            }
        }
    }

    private function isTooSimilar(string $password, string $text): bool
    {
        if (stripos($text, $password) !== false) {
            return true;
        }

        if (stripos($password, $text) !== false) {
            return true;
        }

        return $this->getSimilarity($password, $text) > 60;
    }

    private function getSimilarity(string $password, string $text): int
    {
        $percentDifference = 0;
        similar_text(strtolower($password), strtolower($text), $percentDifference);
        return $percentDifference;
    }
}
