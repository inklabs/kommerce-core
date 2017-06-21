<?php
namespace inklabs\kommerce\Entity;

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

    public function __construct(int $amount, string $checkNumber, DateTime $checkDate, string $memo = null)
    {
        parent::__construct();
        $this->amount = $amount;
        $this->checkNumber = $checkNumber;
        $this->checkDate = $checkDate;
        $this->memo = $memo;
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

    public function getCheckNumber(): string
    {
        return $this->checkNumber;
    }

    public function getCheckDate(): DateTime
    {
        return $this->checkDate;
    }

    public function getMemo(): string
    {
        return $this->memo;
    }
}
