<?php
namespace inklabs\kommerce\Lib\ReferenceNumber;

class SequentialGenerator implements GeneratorInterface
{
    /** @var int */
    protected $padLength = 10;

    /** @var */
    protected $offset = 0;

    public function generate(ReferenceNumberEntityInterface & $entity)
    {
        $index = $this->offset + ((int) $entity->getReferenceId());

        $referenceNumber = str_pad($index, $this->padLength, 0, STR_PAD_LEFT);

        $entity->setReferenceNumber($referenceNumber);
    }

    /**
     * @param int $padLength
     */
    public function setPadLength($padLength)
    {
        $this->padLength = (int)$padLength;
    }

    /**
     * @param int $offset
     */
    public function setOffset($offset)
    {
        $this->offset = (int) $offset;
    }
}
