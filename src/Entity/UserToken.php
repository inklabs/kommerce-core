<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\Event\ResetPasswordEvent;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class UserToken implements IdEntityInterface
{
    use TimeTrait, IdTrait, EventGeneratorTrait;

    /** @var string */
    protected $userAgent;

    /** @var int */
    protected $ip4;

    /** @var string */
    protected $tokenHash;

    /** @var int */
    protected $expires;

    /** @var UserTokenType */
    protected $type;

    /** @var User */
    protected $user;

    /** @var UserLogin[] */
    protected $userLogins;

    public function __construct(
        User $user,
        UserTokenType $type,
        string $token,
        string $userAgent,
        string $ip4,
        DateTime $expires = null
    ) {
        $this->setId();
        $this->setCreated();
        $this->setUser($user);
        $this->setType($type);
        $this->setUserAgent($userAgent);
        $this->setToken($token);
        $this->setIp4($ip4);
        $this->setExpires($expires);

        $this->userLogins = new ArrayCollection();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('userAgent', new Assert\NotBlank);
        $metadata->addPropertyConstraint('userAgent', new Assert\Length([
            'max' => 200,
        ]));

        $metadata->addPropertyConstraint('ip4', new Assert\GreaterThanOrEqual([
            'value' => 0,
        ]));

        $metadata->addPropertyConstraint('tokenHash', new Assert\NotBlank);
        $metadata->addPropertyConstraint('tokenHash', new Assert\Length([
            'max' => 60,
        ]));

        $metadata->addPropertyConstraint('expires', new Assert\GreaterThanOrEqual([
            'value' => 0,
        ]));

        $metadata->addPropertyConstraint('type', new Assert\Valid);
    }

    public static function createResetPasswordToken(User $user, string $token, string $userAgent, string $ip4): self
    {
        $expires = new DateTime('+1 hour');

        $userToken = new self(
            $user,
            UserTokenType::internal(),
            $token,
            $userAgent,
            $ip4,
            $expires
        );

        $userToken->raise(
            new ResetPasswordEvent(
                $user->getId(),
                $user->getEmail(),
                $user->getFullName(),
                $token
            )
        );

        return $userToken;
    }

    private function setUserAgent(string $userAgent)
    {
        $this->userAgent = $userAgent;
    }

    public function getUserAgent()
    {
        return $this->userAgent;
    }

    private function setIp4(string $ip4)
    {
        $this->ip4 = ip2long($ip4);
    }

    public static function getRandomToken(): string
    {
        return bin2hex(random_bytes(20));
    }

    private function setToken(string $token)
    {
        $this->tokenHash = password_hash((string) $token, PASSWORD_BCRYPT);
    }

    public function verifyToken(string $token): bool
    {
        return password_verify($token, $this->tokenHash);
    }

    private function setType(UserTokenType $type)
    {
        $this->type = $type;
    }

    public function getType(): UserTokenType
    {
        return $this->type;
    }

    private function setExpires(DateTime $expires = null)
    {
        if ($expires === null) {
            $this->expires = null;
            return;
        }

        $this->expires = $expires->gettimestamp();
    }

    public function getExpires(): ?DateTime
    {
        if ($this->expires === null) {
            return null;
        }

        $expires = new DateTime();
        $expires->setTimestamp($this->expires);
        return $expires;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function verifyTokenDateValid(DateTime $date = null)
    {
        if ($date === null) {
            $date = new DateTime;
        }

        if ($date->getTimestamp() > $this->expires) {
            return false;
        }

        return true;
    }

    public function addUserLogin(UserLogin $userLogin)
    {
        $this->userLogins->add($userLogin);
    }

    public function getIp4(): string
    {
        return long2ip($this->ip4);
    }

    private function setUser(User $user)
    {
        $user->addUserToken($this);
        $this->user = $user;
    }
}
