<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\Event\PasswordChangedEvent;
use inklabs\kommerce\Lib\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class User implements IdEntityInterface
{
    use TimeTrait, IdTrait, EventGeneratorTrait, StringSetterTrait;

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

    /** @var UserStatusType */
    protected $status;

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

    public function __construct(UuidInterface $id = null)
    {
        $this->setId($id);
        $this->setCreated();
        $this->userRoles = new ArrayCollection;
        $this->userTokens = new ArrayCollection;
        $this->userLogins = new ArrayCollection;
        $this->orders = new ArrayCollection;

        $this->totalLogins = 0;
        $this->lastLogin = null;
        $this->setStatus(UserStatusType::active());
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

        $metadata->addPropertyConstraint('status', new Assert\Valid);
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function setCart(Cart $cart)
    {
        $this->cart = $cart;
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
        $this->setStringOrNull($this->externalId, $externalId);
    }

    public function setStatus(UserStatusType $status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
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
        $oldPasswordHash = $this->passwordHash;
        $this->passwordHash = password_hash((string) $password, PASSWORD_BCRYPT);

        if ($oldPasswordHash !== null) {
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
        if ($this->lastLogin === null) {
            return null;
        }

        $lastLogin = new DateTime();
        $lastLogin->setTimestamp($this->lastLogin);
        return $lastLogin;
    }

    public function addUserRole(UserRole $userRole)
    {
        $this->userRoles->add($userRole);
    }

    /**
     * @return UserRole[]
     */
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
        $this->userTokens->add($userToken);
    }

    /**
     * @return UserToken[]
     */
    public function getUserTokens()
    {
        return $this->userTokens;
    }

    public function addUserLogin(UserLogin $userLogin)
    {
        $this->userLogins[] = $userLogin;

        if ($userLogin->getResult()->isSuccess()) {
            $this->incrementTotalLogins();
        }
    }

    /**
     * @return UserLogin[]
     */
    public function getUserLogins()
    {
        return $this->userLogins;
    }

    public function addOrder(Order $order)
    {
        $order->setUser($this);
        $this->orders[] = $order;
    }

    /**
     * @return Order[]
     */
    public function getOrders()
    {
        return $this->orders;
    }
}
