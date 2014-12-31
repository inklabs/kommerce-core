<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class UserLogin
{
    use Accessor\Created;

    protected $id;
    protected $username;
    protected $ip4;

    protected $result;
    const RESULT_FAIL      = 0;
    const RESULT_SUCCESS   = 1;

    /* @var User */
    protected $user;

    public function __construct()
    {
        $this->setCreated();
        $this->result = static::RESULT_FAIL;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('username', new Assert\NotBlank);
        $metadata->addPropertyConstraint('username', new Assert\Length([
            'max' => 32,
        ]));

        $metadata->addPropertyConstraint('ip4', new Assert\NotBlank);
        $metadata->addPropertyConstraint('ip4', new Assert\GreaterThanOrEqual([
            'value' => 0,
        ]));

        $metadata->addPropertyConstraint('result', new Assert\Choice([
            'choices' => array_keys(static::getResultMapping()),
            'message' => 'The result is not a valid choice',
        ]));
    }

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param $ip4 string
     */
    public function setIp4($ip4)
    {
        $this->ip4 = (int) ip2long($ip4);
    }

    public function getIp4()
    {
        return long2ip($this->ip4);
    }

    public function setResult($result)
    {
        $this->result = (int) $result;
    }

    public function getResult()
    {
        return $this->result;
    }

    public static function getResultMapping()
    {
        return [
            static::RESULT_FAIL => 'Fail',
            static::RESULT_SUCCESS => 'Success',
        ];
    }

    public function getResultText()
    {
        return $this->getResultMapping()[$this->result];
    }


    public function getView()
    {
        return new View\UserLogin($this);
    }
}
