<?php
namespace inklabs\kommerce\Entity;

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
        $this->ip4 = ip2long($ip4);
    }

    /**
     * @return string
     */
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
}
