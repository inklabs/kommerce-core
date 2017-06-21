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

    public function __construct(string $textOptionId, string $textOptionValue)
    {
        $this->textOptionId = Uuid::fromString($textOptionId);
        $this->textOptionValue = $textOptionValue;
    }

    public function getTextOptionId(): UuidInterface
    {
        return $this->textOptionId;
    }

    public function getTextOptionValue(): string
    {
        return $this->textOptionValue;
    }
}
