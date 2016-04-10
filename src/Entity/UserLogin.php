<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\UserLoginDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class UserLogin implements EntityInterface, ValidationInterface
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

    public function __construct()
    {
        $this->setCreated();
        $this->setResult(UserLoginResultType::fail());
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

    public function setEmail($email)
    {
        $this->email = (string) $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setUser(User $user)
    {
        $user->addUserLogin($this);
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $ip4
     */
    public function setIp4($ip4)
    {
        $this->ip4 = (int) ip2long($ip4);
    }

    public function getIp4()
    {
        return long2ip($this->ip4);
    }

    public function setResult(UserLoginResultType $result)
    {
        $this->result = $result;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function setUserToken(UserToken $userToken)
    {
        $userToken->addUserLogin($this);
        $this->userToken = $userToken;
    }

    public function getUserToken()
    {
        return $this->userToken;
    }

    public function getDTOBuilder()
    {
        return new UserLoginDTOBuilder($this);
    }
}
