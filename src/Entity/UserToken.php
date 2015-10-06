<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\UserTokenDTOBuilder;
use inklabs\kommerce\View;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class UserToken implements ValidationInterface
{
    use TimeTrait, IdTrait;

    /** @var string */
    protected $userAgent;

    /** @var string */
    protected $token;

    /** @var int */
    protected $expires;

    /** @var int */
    protected $type;
    const TYPE_GOOGLE   = 0;
    const TYPE_FACEBOOK = 1;
    const TYPE_TWITTER  = 2;
    const TYPE_YAHOO    = 3;

    /** @var User */
    protected $user;

    public function __construct()
    {
        $this->setCreated();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('userAgent', new Assert\NotBlank);
        $metadata->addPropertyConstraint('userAgent', new Assert\Length([
            'max' => 40,
        ]));

        $metadata->addPropertyConstraint('token', new Assert\NotBlank);
        $metadata->addPropertyConstraint('token', new Assert\Length([
            'max' => 40,
        ]));

        $metadata->addPropertyConstraint('expires', new Assert\GreaterThanOrEqual([
            'value' => 0,
        ]));

        $metadata->addPropertyConstraint('type', new Assert\Choice([
            'choices' => array_keys(static::getTypeMapping()),
            'message' => 'The type is not a valid choice',
        ]));
    }

    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
    }

    public function getUserAgent()
    {
        return $this->userAgent;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getToken()
    {
        return $this->token;
    }

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

    public function setExpires(\DateTime $expires = null)
    {
        if ($expires === null) {
            $this->expires = null;
            return;
        }

        $this->expires = $expires->gettimestamp();
    }

    /**
     * @return \DateTime|null
     */
    public function getExpires()
    {
        if ($this->expires === null) {
            return null;
        }

        $expires = new \DateTime();
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

    public function getView()
    {
        return new View\UserToken($this);
    }

    public function getDTOBuilder()
    {
        return new UserTokenDTOBuilder($this);
    }
}
