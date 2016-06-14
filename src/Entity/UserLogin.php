<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class UserLogin implements IdEntityInterface, ValidationInterface
{
    use CreatedTrait, IdTrait;

    /** @var string */
    protected $email;

    /** @var int */
    protected $ip4;

    /** @var UserLoginResultType */
    protected $result;

    /** @var User */
    protected $user;

    /** @var UserToken */
    protected $userToken;

    /**
     * @param UserLoginResultType $result
     * @param string $email
     * @param string $ip4
     * @param User|null $user
     * @param UserToken|null $userToken
     */
    public function __construct(
        UserLoginResultType $result,
        $email,
        $ip4,
        User $user = null,
        UserToken $userToken = null
    ) {
        $this->setId();
        $this->setCreated();
        $this->result = $result;
        $this->email = (string) $email;
        $this->ip4 = (int) ip2long($ip4);

        if ($user !== null) {
            $user->addUserLogin($this);
            $this->user = $user;
        }

        if ($userToken !== null) {
            $userToken->addUserLogin($this);
            $this->userToken = $userToken;
        }
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('email', new Assert\NotBlank);
        $metadata->addPropertyConstraint('email', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('ip4', new Assert\NotBlank);
        $metadata->addPropertyConstraint('ip4', new Assert\GreaterThanOrEqual([
            'value' => 0,
        ]));

        $metadata->addPropertyConstraint('result', new Assert\Valid);
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getIp4()
    {
        return long2ip($this->ip4);
    }

    public function getResult()
    {
        return $this->result;
    }

    public function getUserToken()
    {
        return $this->userToken;
    }
}
