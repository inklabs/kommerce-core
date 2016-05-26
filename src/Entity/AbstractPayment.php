<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\AbstractPaymentDTOBuilder;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractPayment implements EntityInterface, ValidationInterface
{
    use TimeTrait, IdTrait;

    use TempUuidTrait;
    private $order_uuid;

    /** @var int */
    protected $amount;
    /** @var Order */
    protected $order;

    public function __construct()
    {
        $this->setUuid();
        $this->setCreated();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('amount', new Assert\NotNull);
        $metadata->addPropertyConstraint('amount', new Assert\Range([
            'min' => 0,
            'max' => 4294967295,
        ]));
    }

    public function setAmount($amount)
    {
        $this->amount = (int) $amount;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setOrder(Order $order)
    {
        $this->order = $order;
        $this->order_uuid = $order->getUuid();
    }

    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return AbstractPaymentDTOBuilder
     */
    abstract public function getDTOBuilder();

    // TODO: Remove after uuid_migration
    public function setOrderUuid(UuidInterface $uuid)
    {
        $this->order_uuid = $uuid;
    }
}
