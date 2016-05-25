<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\EntityDTO\Builder\UserTokenDTOBuilder;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class UserToken implements EntityInterface, ValidationInterface
{
    use TimeTrait, IdTrait;

    use TempUuidTrait;
    protected $user_uuid;

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

    public function __construct(User $user)
    {
        $this->setUuid();
        $this->setUserUuid($user->getUuid());

        $user->addUserToken($this);
        $this->user = $user;

        $this->setCreated();
        $this->setType(UserTokenType::internal());
        $this->userLogins = new ArrayCollection;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
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

    /**
     * @param string $userAgent
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = (string) $userAgent;
    }

    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @param string $ip4
     */
    public function setIp4($ip4)
    {
        $this->ip4 = (int) ip2long($ip4);
    }

    /**
     * TODO: PHP7 - bin2hex(random_bytes($n))
     * @return string
     */
    public static function getRandomToken()
    {
        return bin2hex(openssl_random_pseudo_bytes(20));
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->tokenHash = password_hash((string) $token, PASSWORD_BCRYPT);
    }

    /**
     * @param string $token
     * @return bool
     */
    public function verifyToken($token)
    {
        return password_verify($token, $this->tokenHash);
    }

    public function setType(UserTokenType $type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setExpires(DateTime $expires = null)
    {
        if ($expires === null) {
            $this->expires = null;
            return;
        }

        $this->expires = $expires->gettimestamp();
    }

    /**
     * @return DateTime|null
     */
    public function getExpires()
    {
        if ($this->expires === null) {
            return null;
        }

        $expires = new DateTime();
        $expires->setTimestamp($this->expires);
        return $expires;
    }

    public function getUser()
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

    public function getDTOBuilder()
    {
        return new UserTokenDTOBuilder($this);
    }

    public function addUserLogin(UserLogin $userLogin)
    {
        $this->userLogins->add($userLogin);
    }

    public function getIp4()
    {
        return long2ip($this->ip4);
    }

    // TODO: Remove after uuid_migration
    public function setUserUuid(UuidInterface $uuid)
    {
        $this->user_uuid = $uuid;
    }
}
