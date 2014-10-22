<?php
namespace inklabs\kommerce\Entity;

class UserLogin
{
    use Accessor\Created;

    protected $id;
    protected $username;
    protected $userId;
    protected $ip4;
    protected $result; // success, fail, failock

    public function __construct()
    {
        $this->setCreated();
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

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setIp4($ip4)
    {
        $this->ip4 = $ip4;
    }

    public function getIp4()
    {
        return $this->ip4;
    }

    public function setResult($result)
    {
        $this->result = $result;
    }

    public function getResult()
    {
        return $this->result;
    }
}
