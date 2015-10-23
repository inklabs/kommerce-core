<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Entity\User;

class UserPasswordValidator
{
    /**
     * @param User $user
     * @param string $password
     * @throws UserPasswordValidationException
     */
    public function assertPasswordValid(User $user, $password)
    {
        if (strlen($password) < 8) {
            throw new UserPasswordValidationException('Password must be at least 8 characters');
        }

        if ($user->verifyPassword($password)) {
            throw new UserPasswordValidationException('Invalid password');
        }

        $tooSimilarValues = [
            $user->getFirstName(),
            $user->getLastName(),
            $user->getFullName(),
            $user->getEmail(),
        ];

        foreach ($tooSimilarValues as $text) {
            if ($this->isTooSimilar($password, $text)) {
                throw new UserPasswordValidationException('Password is too similar to your name or email');
            }
        }
    }

    /**
     * @param $password
     * @param $text
     * @return bool
     */
    private function isTooSimilar($password, $text)
    {
        if (stripos($text, $password) !== false) {
            return true;
        }

        if (stripos($password, $text) !== false) {
            return true;
        }

        return $this->getSimilarity($password, $text) > 60;
    }

    /**
     * @param $password
     * @param $text
     * @return int
     */
    private function getSimilarity($password, $text)
    {
        $percentDifference = 0;
        similar_text(strtolower($password), strtolower($text), $percentDifference);
        return $percentDifference;
    }
}
