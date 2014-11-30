<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class User
{
    use Accessor\Time;

    protected $id;
    protected $email;
    protected $username;
    protected $passwordHash;
    protected $firstName;
    protected $lastName;
    protected $totalLogins;
    protected $lastLogin;

    protected $status;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_LOCKED = 2;

    protected $roles;
    protected $tokens;
    protected $orders;

    public function __construct()
    {
        $this->setCreated();
        $this->roles = new ArrayCollection();
        $this->tokens = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->totalLogins = 0;
        $this->lastLogin = null;
        $this->status = self::STATUS_ACTIVE;
    }

    public function getId()
    {
        return $this->id;
    }

    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($password)
    {
        $this->passwordHash = password_hash($password, PASSWORD_BCRYPT);
    }

    public function verifyPassword($password)
    {
        return password_verify($password, $this->passwordHash);
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function incrementTotalLogins()
    {
        $this->totalLogins++;
        $this->setLastLogin(new \DateTime('now', new \DateTimeZone('UTC')));
    }

    public function getTotalLogins()
    {
        return $this->totalLogins;
    }

    public function setLastLogin(\DateTime $lastLogin)
    {
        $this->lastLogin = $lastLogin->getTimestamp();
    }

    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    public function addRole(Role $role)
    {
        $this->roles[] = $role;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function addToken(UserToken $token)
    {
        $this->tokens[] = $token;
    }

    public function getTokens()
    {
        return $this->tokens;
    }
}
