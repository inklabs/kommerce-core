<?php
namespace inklabs\kommerce\Entity;

class UserToken
{
    use Accessor\Time;

    protected $id;
    protected $userAgent;
    protected $token;
    protected $expires;

    protected $type;
    const TYPE_GOOGLE   = 0;
    const TYPE_FACEBOOK = 1;
    const TYPE_TWITTER  = 2;
    const TYPE_YAHOO    = 3;

    /* @var User */
    protected $user;

    public function __construct()
    {
        $this->setCreated();
    }

    public function getId()
    {
        return $this->id;
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
}
