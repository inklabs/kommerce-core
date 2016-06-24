<?php
namespace inklabs\kommerce\InputDTO;

use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

class TextOptionValueDTO
{
    /** @var UuidInterface */
    private $textOptionId;

    /** @var string */
    private $textOptionValue;

    /**
     * @param string $textOptionId
     * @param string $textOptionValue
     */
    public function __construct($textOptionId, $textOptionValue)
    {
        $this->textOptionId = Uuid::fromString($textOptionId);
        $this->textOptionValue = (string) $textOptionValue;
    }

    public function getTextOptionId()
    {
        return $this->textOptionId;
    }

    public function getTextOptionValue()
    {
        return $this->textOptionValue;
    }
}
