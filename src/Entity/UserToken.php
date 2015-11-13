<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\EntityDTO\Builder\UserTokenDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class UserToken implements EntityInterface, ValidationInterface
{
    use TimeTrait, IdTrait;

    /** @var string */
    protected $userAgent;

    /** @var int */
    protected $ip4;

    /** @var string */
    protected $tokenHash;

    /** @var int */
    protected $expires;

    /** @var int */
    protected $type;
    const TYPE_INTERNAL = 0;
    const TYPE_GOOGLE   = 1;
    const TYPE_FACEBOOK = 2;
    const TYPE_TWITTER  = 3;
    const TYPE_YAHOO    = 4;

    /** @var User */
    protected $user;

    /** @var UserLogin[] */
    protected $userLogins;

    public function __construct()
    {
        $this->setCreated();
        $this->setType(self::TYPE_INTERNAL);
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

        $metadata->addPropertyConstraint('type', new Assert\Choice([
            'choices' => array_keys(static::getTypeMapping()),
            'message' => 'The type is not a valid choice',
        ]));
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

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = (int) $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public static function getTypeMapping()
    {
        return [
            static::TYPE_INTERNAL => 'Internal',
            static::TYPE_GOOGLE => 'Google',
            static::TYPE_FACEBOOK => 'Facebook',
            static::TYPE_TWITTER => 'Twitter',
            static::TYPE_YAHOO => 'Yahoo',
        ];
    }

    public function getTypeText()
    {
        return $this->getTypeMapping()[$this->type];
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

    public function setUser(User $user)
    {
        $this->user = $user;
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
}
