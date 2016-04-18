<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\CheckPaymentDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

class CheckPayment extends AbstractPayment
{
    /** @var string */
    private $checkNumber;

    /** @var DateTime */
    private $checkDate;

    /** @var string */
    private $memo;

    /**
     * @param int $amount
     * @param string $checkNumber
     * @param DateTime $checkDate
     * @param string $memo
     */
    public function __construct($amount, $checkNumber, $checkDate, $memo = null)
    {
        $this->setCreated();
        $this->amount = (int) $amount;
        $this->checkNumber = (string) $checkNumber;
        $this->checkDate = $checkDate;
        $this->memo = (string) $memo;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        parent::loadValidatorMetadata($metadata);

        $metadata->addPropertyConstraint('checkNumber', new Assert\Length([
            'max' => 15,
        ]));

        $metadata->addPropertyConstraint('memo', new Assert\Length([
            'max' => 100,
        ]));

        $metadata->addPropertyConstraint('checkDate', new Assert\Date);
    }

    public function getCheckNumber()
    {
        return $this->checkNumber;
    }

    public function getCheckDate()
    {
        return $this->checkDate;
    }

    public function getMemo()
    {
        return $this->memo;
    }

    /**
     * @return CheckPaymentDTOBuilder
     */
    public function getDTOBuilder()
    {
        return new CheckPaymentDTOBuilder($this);
    }
}
