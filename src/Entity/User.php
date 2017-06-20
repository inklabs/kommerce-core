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

    /** @var string|null */
    protected $externalId;

    /** @var string|null */
    protected $email;

    /** @var string|null */
    protected $passwordHash;

    /** @var string */
    protected $firstName;

    /** @var string|null */
    protected $lastName;

    /** @var int */
    protected $totalLogins;

    /** @var int|null */
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

    /** @var Cart|null */
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

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(?string $externalId = null)
    {
        $this->setStringOrNull($this->externalId, $externalId);
    }

    public function setStatus(UserStatusType $status)
    {
        $this->status = $status;
    }

    public function getStatus(): UserStatusType
    {
        return $this->status;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setPassword(string $password)
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

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->passwordHash);
    }

    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getFullName(): string
    {
        return trim($this->firstName . ' ' . $this->lastName);
    }

    public function incrementTotalLogins()
    {
        $this->totalLogins++;
        $this->setLastLogin(new DateTime('now', new DateTimeZone('UTC')));
    }

    public function getTotalLogins(): int
    {
        return $this->totalLogins;
    }

    private function setLastLogin(DateTime $lastLogin)
    {
        $this->lastLogin = $lastLogin->getTimestamp();
    }

    public function getLastLogin(): ?DateTime
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

    /**
     * @param UserRoleType[] $userRoleTypes
     * @return bool
     */
    public function hasUserRoles(array $userRoleTypes): bool
    {
        $userRoles = [];
        foreach ($this->userRoles as $userRole) {
            $userRoles[$userRole->getUserRoleType()->getId()] = true;
        }

        foreach ($userRoleTypes as $userRoleType) {
            if (! isset($userRoles[$userRoleType->getId()])) {
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
