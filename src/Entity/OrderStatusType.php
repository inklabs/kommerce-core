<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class OrderStatusType implements ValidationInterface
{
    /** @var int */
    private $id;

    const PENDING    = 0;
    const PROCESSING = 1;
    const PARTIALLY_SHIPPED = 2;
    const SHIPPED    = 3;
    const COMPLETE   = 4;
    const CANCELED   = 5;

    /**
     * @param int $id
     * @throws InvalidArgumentException
     */
    private function __construct($id)
    {
        if (! in_array($id, self::validIds())) {
            throw new InvalidArgumentException;
        }

        $this->id = (int) $id;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\Choice([
            'choices' => self::validIds(),
            'message' => 'The type is not a valid choice',
        ]));
    }

    public static function getNameMap()
    {
        return [
            self::PENDING => 'Pending',
            self::PROCESSING => 'Processing',
            self::PARTIALLY_SHIPPED => 'Partially Shipped',
            self::SHIPPED => 'Shipped',
            self::COMPLETE => 'Complete',
            self::CANCELED => 'Canceled',
        ];
    }

    /**
     * @return array
     */
    private static function validIds()
    {
        return array_keys(self::getNameMap());
    }

    public function getName()
    {
        return $this->getNameMap()[$this->id];
    }


    /**
     * @param int $id
     * @return OrderStatusType
     */
    public static function createById($id)
    {
        return new self($id);
    }

    public static function pending()
    {
        return new self(self::PENDING);
    }

    public static function processing()
    {
        return new self(self::PROCESSING);
    }

    public static function partiallyShipped()
    {
        return new self(self::PARTIALLY_SHIPPED);
    }

    public static function shipped()
    {
        return new self(self::SHIPPED);
    }

    public static function complete()
    {
        return new self(self::COMPLETE);
    }

    public static function canceled()
    {
        return new self(self::CANCELED);
    }

    public function isPending()
    {
        return $this->id === self::PENDING;
    }

    public function isProcessing()
    {
        return $this->id === self::PROCESSING;
    }

    public function isPartiallyShipped()
    {
        return $this->id === self::PARTIALLY_SHIPPED;
    }

    public function isShipped()
    {
        return $this->id === self::SHIPPED;
    }

    public function isComplete()
    {
        return $this->id === self::COMPLETE;
    }

    public function isCanceled()
    {
        return $this->id === self::CANCELED;
    }
}
