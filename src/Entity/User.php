<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class User implements EntityInterface
{
    use Accessor\Time, Accessor\Id;

    /** @var string */
    protected $externalId;

    /** @var string */
    protected $email;

    /** @var string */
    protected $passwordHash;

    /** @var string */
    protected $firstName;

    /** @var string */
    protected $lastName;

    /** @var int */
    protected $totalLogins;

    /** @var int */
    protected $lastLogin;


    /** @var int */
    protected $status;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_LOCKED = 2;

    /** @var ArrayCollection|UserRole[] */
    protected $roles;

    /** @var ArrayCollection|UserToken[] */
    protected $tokens;

    /** @var ArrayCollection|Order[] */
    protected $orders;

    /** @var ArrayCollection|UserLogin[] */
    protected $logins;

    public function __construct()
    {
        $this->setCreated();
        $this->roles = new ArrayCollection();
        $this->tokens = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->logins = new ArrayCollection();

        $this->totalLogins = 0;
        $this->lastLogin = null;
        $this->status = self::STATUS_ACTIVE;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('firstName', new Assert\NotBlank);
        $metadata->addPropertyConstraint('firstName', new Assert\Length([
            'max' => 50,
        ]));

        $metadata->addPropertyConstraint('lastName', new Assert\NotBlank);
        $metadata->addPropertyConstraint('lastName', new Assert\Length([
            'max' => 50,
        ]));

        $metadata->addPropertyConstraint('email', new Assert\NotBlank);
        $metadata->addPropertyConstraint('email', new Assert\Length([
            'max' => 255,
        ]));
        $metadata->addPropertyConstraint('email', new Assert\Email);

        $metadata->addPropertyConstraint('passwordHash', new Assert\NotBlank);

        $metadata->addPropertyConstraint('totalLogins', new Assert\NotBlank);
        $metadata->addPropertyConstraint('totalLogins', new Assert\GreaterThanOrEqual([
            'value' => 0,
        ]));

        $metadata->addPropertyConstraint('lastLogin', new Assert\GreaterThanOrEqual([
            'value' => 0,
        ]));

        $metadata->addPropertyConstraint('status', new Assert\Choice([
            'choices' => array_keys(static::getStatusMapping()),
            'message' => 'The status is not a valid choice',
        ]));

    }

    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @param string $externalId
     */
    public function setExternalId($externalId)
    {
        $this->externalId = (string) $externalId;
    }

    public function setStatus($status)
    {
        $this->status = (int) $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public static function getStatusMapping()
    {
        return [
            static::STATUS_INACTIVE => 'Inactive',
            static::STATUS_ACTIVE => 'Active',
            static::STATUS_LOCKED => 'Locked',
        ];
    }

    public function getStatusText()
    {
        return $this->getStatusMapping()[$this->status];
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
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

    public function addRole(UserRole $role)
    {
        $this->roles[] = $role;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function hasRoles(array $roleNames)
    {
        $userRoles = [];
        foreach ($this->roles as $role) {
            $userRoles[$role->getName()] = true;
        }

        foreach ($roleNames as $roleName) {
            if (! isset($userRoles[$roleName])) {
                return false;
            }
        }

        return true;
    }

    public function addToken(UserToken $token)
    {
        $token->setUser($this);
        $this->tokens[] = $token;
    }

    public function getTokens()
    {
        return $this->tokens;
    }

    public function addLogin(UserLogin $login)
    {
        $login->setUser($this);
        $this->logins[] = $login;

        if ($login->getResult() == UserLogin::RESULT_SUCCESS) {
            $this->incrementTotalLogins();
        }
    }

    public function getLogins()
    {
        return $this->logins;
    }

    public function addOrder(Order $order)
    {
        $order->setUser($this);
        $this->orders[] = $order;
    }

    public function getOrders()
    {
        return $this->orders;
    }

    public function getView()
    {
        return new View\User($this);
    }
}
