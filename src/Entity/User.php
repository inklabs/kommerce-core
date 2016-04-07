<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use DateTimeZone;
use inklabs\kommerce\EntityDTO\Builder\UserDTOBuilder;
use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\Event\PasswordChangedEvent;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class User implements EntityInterface, ValidationInterface
{
    use TimeTrait, IdTrait, EventGeneratorTrait;

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

    /** @var DateTime */
    protected $lastLogin;

    /** @var int */
    protected $status;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_LOCKED = 2;

    /** @var ArrayCollection|UserRole[] */
    protected $userRoles;

    /** @var ArrayCollection|UserToken[] */
    protected $userTokens;

    /** @var ArrayCollection|UserLogin[] */
    protected $userLogins;

    /** @var ArrayCollection|Order[] */
    protected $orders;

    /** @var Cart */
    protected $cart;

    public function __construct()
    {
        $this->setCreated();
        $this->userRoles = new ArrayCollection;
        $this->userTokens = new ArrayCollection;
        $this->userLogins = new ArrayCollection;
        $this->orders = new ArrayCollection;

        $this->totalLogins = 0;
        $this->lastLogin = null;
        $this->status = static::STATUS_ACTIVE;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('firstName', new Assert\NotBlank);
        $metadata->addPropertyConstraint('firstName', new Assert\Length([
            'max' => 50,
        ]));

        $metadata->addPropertyConstraint('lastName', new Assert\Length([
            'max' => 50,
        ]));

        $metadata->addPropertyConstraint('email', new Assert\Length([
            'max' => 255,
        ]));
        $metadata->addPropertyConstraint('email', new Assert\Email);

        $metadata->addPropertyConstraint('passwordHash', new Assert\Length([
            'max' => 60,
        ]));

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

    public function getCart()
    {
        return $this->cart;
    }

    public function setCart(Cart $cart)
    {
        $this->cart = $cart;
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
    public function setExternalId($externalId = null)
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

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = (string) $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->passwordHash = password_hash((string) $password, PASSWORD_BCRYPT);

        if ($this->id !== null) {
            $this->raise(
                new PasswordChangedEvent(
                    $this->id,
                    $this->email,
                    $this->getFullName()
                )
            );
        }
    }

    /**
     * @param string $password
     * @return bool
     */
    public function verifyPassword($password)
    {
        return password_verify($password, $this->passwordHash);
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = (string) $firstName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = (string) $lastName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getFullName()
    {
        return trim($this->firstName . ' ' . $this->lastName);
    }

    public function incrementTotalLogins()
    {
        $this->totalLogins++;
        $this->setLastLogin(new DateTime('now', new DateTimeZone('UTC')));
    }

    public function getTotalLogins()
    {
        return $this->totalLogins;
    }

    private function setLastLogin(DateTime $lastLogin)
    {
        $this->lastLogin = $lastLogin->getTimestamp();
    }

    public function getLastLogin()
    {
        $lastLogin = new DateTime();
        $lastLogin->setTimestamp($this->lastLogin);
        return $lastLogin;
    }

    public function addUserRole(UserRole $userRole)
    {
        $this->userRoles->add($userRole);
    }

    public function getUserRoles()
    {
        return $this->userRoles;
    }

    public function hasUserRoles(array $roleNames)
    {
        $userRoles = [];
        foreach ($this->userRoles as $role) {
            $userRoles[$role->getName()] = true;
        }

        foreach ($roleNames as $roleName) {
            if (! isset($userRoles[$roleName])) {
                return false;
            }
        }

        return true;
    }

    public function addUserToken(UserToken $userToken)
    {
        $userToken->setUser($this);
        $this->userTokens[] = $userToken;
    }

    public function getUserTokens()
    {
        return $this->userTokens;
    }

    public function addUserLogin(UserLogin $userLogin)
    {
        $this->userLogins[] = $userLogin;

        if ($userLogin->getResult() == UserLogin::RESULT_SUCCESS) {
            $this->incrementTotalLogins();
        }
    }

    public function getUserLogins()
    {
        return $this->userLogins;
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

    public function getDTOBuilder()
    {
        return new UserDTOBuilder($this);
    }
}
