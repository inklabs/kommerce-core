<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class User
{
    use Accessor\Time;

    protected $id;
    protected $email;
    protected $username;
    protected $password;
    protected $firstName;
    protected $lastName;
    protected $logins;
    protected $lastLogin;

    protected $roles;
    protected $tokens;

    public function __construct()
    {
        $this->setCreated();
        $this->roles = new ArrayCollection();
        $this->tokens = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
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
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
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

    public function setLogins($logins)
    {
        $this->logins = $logins;
    }

    public function getLogins()
    {
        return $this->logins;
    }

    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
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
